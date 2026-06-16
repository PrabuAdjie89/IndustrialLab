<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangUnit;
use App\Http\Requests\StoreBarangKeluarReq;
use App\Http\Requests\UpdateBarangKeluarReq;
use App\Exports\BarangKeluarExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangKeluarController extends Controller
{
    public $pageTitle = 'Barang Keluar';

    public function index()
    {
        $pageTitle = $this->pageTitle;

        $perPage = request()->query('perPage') ?? 10;

        $search = request()->query('search');

        $query = BarangKeluar::with(
            'barang:id,kode_barang,nama_barang,stok'
        );

        if ($search) {

            $query->whereHas('barang', function ($q) use ($search) {

                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhere('kode_barang', 'like', "%$search%");

            });

        }

        $data = $query->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        $barang = Barang::with('units')->get();

        confirmDelete('Apakah Anda yakin ingin menghapus data ini?');

        return view(
            'barang-keluar.index',
            compact(
                'pageTitle',
                'data',
                'barang'
            )
        );
    }

    public function store(StoreBarangKeluarReq $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',

            'unit_ids' => 'required|array|min:1',

            'unit_ids.*' => 'exists:barang_units,id',

            'tanggal_keluar' => 'required|date',
        ]);

        $jumlah = count($request->unit_ids);

        $barangKeluar = BarangKeluar::create([
            'barang_id'      => $request->barang_id,

            'jumlah'         => $jumlah,

            'tanggal_keluar' => $request->tanggal_keluar,

            'keterangan'     => $request->keterangan,
        ]);

        BarangUnit::whereIn('id', $request->unit_ids)
            ->delete();

        $barang = Barang::find($request->barang_id);

        $barang->update([
            'stok' => $barang->units()->count()
        ]);

        toast()->success('Barang keluar berhasil ditambahkan');

        return redirect()->route('master-data.barang-keluar.index');
    }

    public function update(
        UpdateBarangKeluarReq $request,
        BarangKeluar $barangKeluar
    )
    {
        $barang = $barangKeluar->barang;

        $lastUrut = BarangUnit::getLastUrut($barang->id);

        for ($i = 1; $i <= $barangKeluar->jumlah; $i++) {

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

        $barangKeluar->update([
            'barang_id'      => $request->barang_id,

            'jumlah'         => $request->jumlah,

            'tanggal_keluar' => $request->tanggal_keluar,

            'keterangan'     => $request->keterangan,
        ]);

        $units = $barang->units()
            ->where('status', 'tersedia')
            ->latest()
            ->take($request->jumlah)
            ->get();

        foreach ($units as $unit) {

            $unit->delete();

        }

        $barang->update([
            'stok' => $barang->units()->count()
        ]);

        toast()->success('Barang keluar berhasil diperbarui');

        return redirect()->route('master-data.barang-keluar.index');
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
                'barang-masuk-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $tahun .
                '.xlsx';

        } else {

            $namaFile =
                'barang-masuk-periode-' .
                $namaBulan[$bulanAwal] .
                '-' .
                $namaBulan[$bulanAkhir] .
                '-' .
                $tahun .
                '.xlsx';

        }

        return Excel::download(
            new BarangKeluarExport(
                $tanggalAwal,
                $tanggalAkhir
            ),
            $namaFile
        );
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        $barang = $barangKeluar->barang;

        $lastUrut = BarangUnit::getLastUrut($barang->id);

        for ($i = 1; $i <= $barangKeluar->jumlah; $i++) {

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

        $barang->update([
            'stok' => $barang->units()->count()
        ]);

        $barangKeluar->delete();

        toast()->success('Data barang keluar berhasil dihapus');

        return redirect()->route('master-data.barang-keluar.index');
    }
}