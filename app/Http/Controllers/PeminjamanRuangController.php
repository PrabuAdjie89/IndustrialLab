<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use Carbon\Carbon;
use App\Http\Requests\storePeminjamanRuanganReq;
use App\Http\Requests\updatePeminjamanRuanganReq;
use Illuminate\Support\Facades\DB;
use App\Exports\PeminjamanRuangExport;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanRuangController extends Controller
{
    public function index()
    {
        $pageTitle = 'Data Peminjaman Ruangan';
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);

        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        $jumlahHari = Carbon::create(
            $tahun,
            $bulan,
            1
        )->daysInMonth;

        $jadwal = PeminjamanRuangan::with('ruangan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereIn('status', ['disetujui','selesai'])
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal . '_' . $item->ruangan_id;
            });

        $perPage = request()->query('perPage') ?? 10;
        $search  = request()->query('search');

        $query = PeminjamanRuangan::with(['user', 'ruangan']);

        if ($search) {
            $query->where('nama_peminjam', 'like', "%$search%")
                  ->orWhere('nama_kegiatan', 'like', "%$search%");
        }

        $peminjamanRuang = $query
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        $ruangans = Ruangan::all();

        return view('peminjaman-ruang.index', compact('pageTitle', 'peminjamanRuang', 'ruangans', 'jadwal', 'bulan', 'tahun', 'jumlahHari'));
    }
    public function jadwal()
    {
        $pageTitle = 'Jadwal Penggunaan Ruangan';

        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);

        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        $jumlahHari = Carbon::create(
            $tahun,
            $bulan,
            1
        )->daysInMonth;

        $jadwal = PeminjamanRuangan::with('ruangan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereIn('status', ['disetujui','selesai'])
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal . '_' . $item->ruangan_id;
            });

        return view('peminjaman-ruang.jadwal',
            compact(
                'pageTitle',
                'ruangans',
                'jadwal',
                'bulan',
                'tahun',
                'jumlahHari'
            )
        );
    }

    public function store(storePeminjamanRuanganReq $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $user = auth()->user();

                
                if ($user->isAsisten() || $user->isLaboran() || $user->isKalab()) {
                    $status = 'disetujui';
                    $approvedBy = $user->id;
                    $approvedAt = now();
                } else {
                    $status = 'menunggu';
                    $approvedBy = null;
                    $approvedAt = null;
                }

                
                if ($status === 'disetujui') {
                    $exists = PeminjamanRuangan::where('ruangan_id', $request->ruangan_id)
                        ->where('tanggal', $request->tanggal)
                        ->where('status', 'disetujui')
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                              ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai])
                              ->orWhere(function ($q2) use ($request) {
                                  $q2->where('waktu_mulai', '<=', $request->waktu_mulai)
                                     ->where('waktu_selesai', '>=', $request->waktu_selesai);
                              });
                        })
                        ->exists();

                    if ($exists) {
                        throw new \Exception('Ruangan sudah dipakai di waktu tersebut');
                    }
                }

                PeminjamanRuangan::create([
                    ...$request->validated(),
                    'user_id'     => $user->id,
                    'status'      => $status,
                    'approved_by' => $approvedBy,
                    'approved_at' => $approvedAt,
                ]);
            });

        } catch (\Exception $e) {
            toast()->error($e->getMessage());
            return back();
        }

        toast()->success('Pengajuan peminjaman ruangan berhasil dikirim');
        return back();
    }

    public function verify(updatePeminjamanRuanganReq $request, PeminjamanRuangan $peminjamanRuang)
    {
   
        if (!in_array(auth()->user()->role, ['laboran', 'kalab'])) {
            abort(403, 'Akses ditolak');
        }

        try {
            DB::transaction(function () use ($request, $peminjamanRuang) {

                if ($request->status === 'disetujui') {

                    $exists = PeminjamanRuangan::where('ruangan_id', $peminjamanRuang->ruangan_id)
                        ->where('tanggal', $peminjamanRuang->tanggal)
                        ->where('id', '!=', $peminjamanRuang->id)
                        ->where('status', 'disetujui')
                        ->where(function ($q) use ($peminjamanRuang) {
                            $q->whereBetween('waktu_mulai', [$peminjamanRuang->waktu_mulai, $peminjamanRuang->waktu_selesai])
                              ->orWhereBetween('waktu_selesai', [$peminjamanRuang->waktu_mulai, $peminjamanRuang->waktu_selesai])
                              ->orWhere(function ($q2) use ($peminjamanRuang) {
                                  $q2->where('waktu_mulai', '<=', $peminjamanRuang->waktu_mulai)
                                     ->where('waktu_selesai', '>=', $peminjamanRuang->waktu_selesai);
                              });
                        })
                        ->exists();

                    if ($exists) {
                        throw new \Exception('Jadwal bentrok dengan peminjaman lain');
                    }
                }

                $peminjamanRuang->update([
                    'status'      => $request->status,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);
            });

        } catch (\Exception $e) {
            toast()->error($e->getMessage());
            return back();
        }

        toast()->success('Peminjaman berhasil diverifikasi');
        return back();
    }

    public function update(updatePeminjamanRuanganReq $request, PeminjamanRuangan $peminjamanRuang)
    {
   
        if (!in_array(auth()->user()->role, ['laboran', 'kalab'])) {
            abort(403, 'Akses ditolak');
        }

        try {
            DB::transaction(function () use ($peminjamanRuang) {

                if (!in_array($peminjamanRuang->status, ['disetujui', 'dipakai'])) {
                    abort(403, 'Status tidak valid');
                }

                $peminjamanRuang->update([
                    'status' => 'selesai',
                ]);
            });

        } catch (\Exception $e) {
            toast()->error('Terjadi kesalahan');
            return back();
        }

        toast()->success('Peminjaman selesai');
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
                'peminjaman-ruangan-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $tahun .
                '.xlsx';


        } else {


            $namaFile =
                'peminjaman-ruangan-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $namaBulan[$bulanAkhir] .
                '-' .
                $tahun .
                '.xlsx';

        }




        return Excel::download(

            new PeminjamanRuanganExport(
                $tanggalAwal,
                $tanggalAkhir
            ),

            $namaFile

        );
    }

    public function destroy(PeminjamanRuangan $peminjamanRuang)
    {
       
        if (!in_array(auth()->user()->role, ['laboran', 'kalab'])) {
            abort(403, 'Akses ditolak');
        }

        if ($peminjamanRuang->status === 'disetujui') {
            abort(403, 'Peminjaman sedang berlangsung');
        }

        $peminjamanRuang->delete();

        toast()->success('Data peminjaman berhasil dihapus');
        return redirect()->route('peminjaman-ruang.index');
    }
}