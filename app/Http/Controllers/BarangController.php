<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeBarangReq;
use App\Http\Requests\updataBarangReq;
use App\Models\Barang;
use App\Models\BarangUnit;
use App\Exports\BarangSheetExport;
use App\Exports\LaporanBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    public $pageTitle = "Data Barang";

    public function index()
    {
        $pageTitle = $this->pageTitle;
        $perPage   = request()->query('perPage') ?? 10;
        $search    = request()->query('search');

        $query = Barang::with('kategori:id,nama_kategori');

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
        }

        $barang = $query
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        confirmDelete('Apakah Anda yakin ingin menghapus data ini?');

        return view('barang.index', compact('pageTitle', 'barang'));
    }

    public function store(storeBarangReq $request)
    {
        DB::beginTransaction();

        try {

            $gambarPath = null;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('barang', 'public');
            }

            $barang = Barang::create([
                'kategori_barang_id' => $request->kategori_barang_id,
                'kode_barang'        => Barang::generateKode(),
                'nama_barang'        => $request->nama_barang,
                'deskripsi_barang'   => $request->deskripsi_barang,
                'gambar'             => $gambarPath,
                'bisa_dipinjam'      => $request->bisa_dipinjam,
                'stok'               => $request->stok ?? 0,
            ]);

            for ($i = 1; $i <= $barang->stok; $i++) {

                BarangUnit::create([
                    'barang_id' => $barang->id,

                    'kode_unit' => BarangUnit::generateKodeUnit(
                        $barang->kode_barang,
                        $i
                    ),

                    'status' => 'tersedia',

                    'kondisi' => 'Baik',
                ]);
            }

            DB::commit();

            toast()->success('Barang berhasil ditambahkan');

            return redirect()->route('master-data.barang.show', $barang->id);

        } catch (\Exception $e) {

            DB::rollBack();

            toast()->error('Barang gagal ditambahkan');

            return back()->withInput();
        }
    }

    public function update(updataBarangReq $request, Barang $barang)
    {
        DB::beginTransaction();

        try {

            $gambarPath = $barang->gambar;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('barang', 'public');
            }

            $stokLama = $barang->stok;

            $barang->update([
                'kategori_barang_id' => $request->kategori_barang_id,
                'kode_barang'        => $barang->kode_barang,
                'nama_barang'        => $request->nama_barang,
                'deskripsi_barang'   => $request->deskripsi_barang,
                'gambar'             => $gambarPath,
                'bisa_dipinjam'      => $request->bisa_dipinjam,
                'stok'               => $request->stok,
            ]);

            $stokBaru = $request->stok;

            if ($stokBaru > $stokLama) {

                $tambahan = $stokBaru - $stokLama;

                $lastUrut = BarangUnit::getLastUrut($barang->id);

                for ($i = 1; $i <= $tambahan; $i++) {

                    $nomorUrut = $lastUrut + $i;

                    BarangUnit::create([

                        'barang_id' => $barang->id,

                        'kode_unit' => BarangUnit::generateKodeUnit(
                            $barang->kode_barang,
                            $nomorUrut
                        ),

                        'status' => 'tersedia',

                        'kondisi' => 'Baik',
                    ]);
                }
            } elseif ($stokBaru < $stokLama) {

                $pengurangan = $stokLama - $stokBaru;

                $units = $barang->units()
                    ->where('status', 'tersedia')
                    ->latest()
                    ->take($pengurangan)
                    ->get();

                foreach ($units as $unit) {
                    $unit->delete();
                }
            }

            DB::commit();

            toast()->success('Barang berhasil diperbarui');

            return redirect()->route('master-data.barang.index');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());
        }
    }

    public function show(Barang $barang)
    {
        $pageTitle = $this->pageTitle;

        $barang->load('units');

        return view('barang.show', compact('barang', 'pageTitle'));
    }

    public function export()
    {
        return Excel::download(new LaporanBarangExport, 'laporan-barang.xlsx');
    }

    public function destroy(Barang $barang)
    {
        if (
            $barang->barangMasuk()->exists() ||
            $barang->barangKeluar()->exists() ||
            $barang->detailPeminjaman()->exists()
        ) {

            toast()->error(
                'Barang tidak dapat dihapus karena masih memiliki riwayat transaksi.'
            );

            return redirect()->route('master-data.barang.index');
        }

        $barang->units()->delete();

        $barang->delete();

        toast()->success('Barang berhasil dihapus');

        return redirect()->route('master-data.barang.index');
    }

    public function updateStatus(Request $request, BarangUnit $unit)
    {
        if (auth()->user()->role != 'laboran') {
            abort(403);
        }

        $request->validate([
            'status' => [
                'required',
                'in:tersedia,dipinjam,rusak,maintenance'
            ],

            'kondisi' => [
                'required',
                'in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat,Perlu Maintenance'
            ]
        ]);

        $kondisi = $request->kondisi;

        if ($request->status == 'rusak') {
            $kondisi = 'Rusak Berat';
        }

        if ($request->status == 'maintenance') {
            $kondisi = 'Perlu Maintenance';
        }

        $unit->update([
            'status' => $request->status,
            'kondisi' => $kondisi
        ]);

        toast()->success('Data unit berhasil diperbarui');

        return back();
    }

    public function printQr($id)
    {
        if (auth()->user()->role != 'laboran') {
            abort(403);
        }

        $barang = Barang::with('units')->findOrFail($id);

        $pdf = Pdf::loadView('master-data.barang.pdf-qr', [
            'barang' => $barang
        ])->setPaper('a4');

        return $pdf->stream('qr-' . $barang->kode_barang . '.pdf');
    }
}