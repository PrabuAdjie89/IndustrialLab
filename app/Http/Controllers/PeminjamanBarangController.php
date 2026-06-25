<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PeminjamanBarang;
use App\Notifications\PengajuanPeminjamanBarang;
use App\Notifications\StatusPeminjamanBarang;
use App\Models\DetailPeminjamanAlat;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PeminjamanBarangExport;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanBarangController extends Controller
{
    public function index()
    {
        $pageTitle = 'Data Peminjaman';

        $perPage = request()->query('perPage') ?? 10;
        $search  = request()->query('search');

        $query = PeminjamanBarang::with('user');

        if ($search) {
            $query->where('unit_peminjam', 'like', '%' . $search . '%');
        }

        $peminjaman = $query
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        $barangs = \App\Models\Barang::where('bisa_dipinjam', true)->get();

        // Ambil SOP dari database
        $sop = Setting::where(
            'key',
            'sop_peminjaman_barang'
        )->value('value');
        
        return view(
            'peminjaman.index',
            compact(
                'pageTitle',
                'peminjaman',
                'barangs',
                'sop'
            )
        );
    }


    public function store(Request $request)
    {
    $request->validate([
        'unit_peminjam'     => 'required|string',
        'nomor_telepon' => ['required', 'regex:/^(08|\+628)[0-9]{8,13}$/'],
        'tanggal_pinjam'   => 'required|date',
        'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
        'barang_id'        => 'required|array|min:1',
        'barang_id.*'      => 'required|exists:barangs,id',
        'jumlah'           => 'required|array',
        'jumlah.*'         => 'required|integer|min:1',
        'surat_peminjaman' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    DB::transaction(function () use ($request) {

     
        $peminjaman = PeminjamanBarang::create([
            'unit_peminjam'    => $request->unit_peminjam,
            'nomor_telepon'    => $request->nomor_telepon,
            'user_id'          => auth()->id(),
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'           => 'menunggu',
        ]);
        $file = $request->file('surat_peminjaman');
        $path = $file->store('surat_peminjaman', 'public');

      
        foreach ($request->barang_id as $index => $barangId) {

           
            $peminjaman->detailPeminjaman()->create([
                
                'barang_id'        => $barangId,
                'jumlah'           => $request->jumlah[$index],
                'surat_peminjaman' => $path,
            ]);
            

        }
        $peminjaman->load('user', 'detailPeminjaman.barang');

        $users = User::whereIn('role', ['laboran', 'kalab'])
            ->whereNotNull('email_verified_at')
            ->get();

        foreach ($users as $user) {
            $user->notify(new PengajuanPeminjamanBarang($peminjaman));
        }
        
    });

    toast()->success('Pengajuan peminjaman berhasil dikirim');
    


    return back();
    
    }


    public function show(PeminjamanBarang $peminjaman)
    {
        $pageTitle = 'Detail Peminjaman';

        $peminjaman->load('detailPeminjaman.barang');

        return view('peminjaman.show', compact('pageTitle', 'peminjaman'));
    }

    public function verify(Request $request, PeminjamanBarang $peminjaman)
    {
        if (!in_array(auth()->user()->role, ['laboran', 'kalab'])) {
            abort(403, 'Akses ditolak');
        }
        $request->validate([
            'status' => 'required|in:dipinjam,ditolak',
        ]);

        $peminjaman->load('detailPeminjaman.barang');

        try {
            DB::transaction(function () use ($request, $peminjaman) {

                if ($request->status === 'dipinjam') {
                    foreach ($peminjaman->detailPeminjaman as $detail) {

                        if (!$detail->barang) {
                            throw new \Exception('Data barang tidak ditemukan');
                        }

                        if ($detail->barang->stok < $detail->jumlah) {
                            throw new \Exception(
                                'Stok barang "' . $detail->barang->nama_barang . '" tidak mencukupi'
                            );
                        }

                        $detail->barang->decrement('stok', $detail->jumlah);

                        if ($detail->barang->stok <= 0) {
                            $detail->barang->update(['bisa_dipinjam' => false]);
                        }
                    }
                }

                $peminjaman->update([
                    'status' => $request->status,
                ]);

                $peminjaman->load('user', 'detailPeminjaman.barang');

                $peminjaman->user->notify(
                    new StatusPeminjamanBarang($peminjaman)
                );
            });

        } catch (\Exception $e) {
            toast()->error($e->getMessage());
            return back();
        }

        toast()->success('Peminjaman berhasil diverifikasi');
        return back();
    }

    public function update(Request $request, PeminjamanBarang $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:selesai',
        ]);

        $peminjaman->load('detailPeminjaman.barang');

        DB::transaction(function () use ($peminjaman) {

            if ($peminjaman->status !== 'dipinjam') {
                abort(403, 'Status tidak valid');
            }

            foreach ($peminjaman->detailPeminjaman as $detail) {
                if (!$detail->barang) continue;

                $detail->barang->increment('stok', $detail->jumlah);
                $detail->barang->update(['bisa_dipinjam' => true]);
            }

            $peminjaman->update([
                'status' => 'selesai',
            ]);
        });

        toast()->success('Barang berhasil dikembalikan');
        return back();
    }
    public function export()
    {
        $bulanAwal  = request('bulan_awal');
        $bulanAkhir = request('bulan_akhir');
        $tahun      = request('tahun');

        $tanggalAwal = date(
            'Y-m-d',
            strtotime("$tahun-$bulanAwal-01")
        );

        $tanggalAkhir = date(
            'Y-m-t',
            strtotime("$tahun-$bulanAkhir-01")
        );

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        if ($bulanAwal == $bulanAkhir) {

            $namaFile =
                'peminjaman-barang-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $tahun .
                '.xlsx';

        } else {

            $namaFile =
                'peminjaman-barang-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $namaBulan[$bulanAkhir] .
                '-' .
                $tahun .
                '.xlsx';
        }

        return Excel::download(
            new PeminjamanBarangExport(
                $tanggalAwal,
                $tanggalAkhir
            ),
            $namaFile
        );
    }
    public function destroy(PeminjamanBarang $peminjaman)
    {
        if ($peminjaman->status === 'dipinjam') {
            abort(403, 'Peminjaman sedang berlangsung');
        }
        $peminjaman->delete();
        toast()->success('Data peminjaman berhasil dihapus');
        return redirect()->route('peminjaman.index');
    }

    
}
