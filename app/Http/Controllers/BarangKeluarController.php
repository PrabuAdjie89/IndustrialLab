<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangUnit;
use App\Models\BarangKeluarUnit;
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
            'barang:id,kode_barang,nama_barang,stok','units'
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

        $units = BarangUnit::whereIn(
            'id',
            $request->unit_ids
        )->get();

        foreach ($units as $unit) {

            BarangKeluarUnit::create([

                'barang_keluar_id' => $barangKeluar->id,

                'barang_unit_id' => $unit->id,

                'kode_unit' => $unit->kode_unit,

            ]);

        }

        BarangUnit::whereIn(
            'id',
            $request->unit_ids
        )->update([
            'status' => 'keluar'
        ]);

        $barang = Barang::find(
            $request->barang_id
        );

        $barang->update([
            'stok' => $barang->units()
                ->where('status', '!=', 'keluar')
                ->count()
        ]);

        toast()->success(
            'Barang keluar berhasil ditambahkan'
        );

        return redirect()->route(
            'master-data.barang-keluar.index'
        );
    }

    public function update( UpdateBarangKeluarReq $request, BarangKeluar $barangKeluar)
    {
        $oldUnitIds = $barangKeluar
            ->units
            ->pluck('barang_unit_id');

        BarangUnit::whereIn(
            'id',
            $oldUnitIds
        )->update([
            'status' => 'tersedia'
        ]);

        $barangKeluar->units()->delete();

        $units = BarangUnit::whereIn(
            'id',
            $request->unit_ids
        )->get();

        foreach ($units as $unit) {

            BarangKeluarUnit::create([

                'barang_keluar_id' => $barangKeluar->id,

                'barang_unit_id' => $unit->id,

                'kode_unit' => $unit->kode_unit,

            ]);

        }

        BarangUnit::whereIn(
            'id',
            $request->unit_ids
        )->update([
            'status' => 'keluar'
        ]);

        $barangKeluar->update([

            'barang_id' => $request->barang_id,

            'jumlah' => count($request->unit_ids),

            'tanggal_keluar' => $request->tanggal_keluar,

            'keterangan' => $request->keterangan,

        ]);

        $barang = Barang::find(
            $request->barang_id
        );

        $barang->update([
            'stok' => $barang->units()
                ->where('status', '!=', 'keluar')
                ->count()
        ]);

        toast()->success(
            'Barang keluar berhasil diperbarui'
        );

        return redirect()->route(
            'master-data.barang-keluar.index'
        );
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
        $unitIds = $barangKeluar
            ->units
            ->pluck('barang_unit_id');

        BarangUnit::whereIn(
            'id',
            $unitIds
        )->update([
            'status' => 'tersedia'
        ]);

        $barang = $barangKeluar->barang;

        $barangKeluar->delete();

        $barang->update([
            'stok' => $barang->units()
                ->where('status', '!=', 'keluar')
                ->count()
        ]);

        toast()->success(
            'Data barang keluar berhasil dihapus'
        );

        return redirect()->route(
            'master-data.barang-keluar.index'
        );
    }
}