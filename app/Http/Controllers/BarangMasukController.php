<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangUnit;
use App\Http\Requests\StoreBarangMasukReq;
use App\Http\Requests\UpdateBarangMasukReq;
use App\Exports\BarangMasukExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangMasukController extends Controller
{
    public $pageTitle = 'Barang Masuk';

    public function index()
    {
        $pageTitle = $this->pageTitle;
        $perPage   = request()->query('perPage') ?? 10;
        $search    = request()->query('search');

        $query = BarangMasuk::with('barang:id,kode_barang,nama_barang');

        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhere('kode_barang', 'like', "%$search%");
            });
        }

        $data = $query->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        confirmDelete('Apakah Anda yakin ingin menghapus data ini?');

        return view('barang-masuk.index', compact('pageTitle', 'data'));
    }

    public function store(StoreBarangMasukReq $request)
    {
        $barangMasuk = BarangMasuk::create([
            'barang_id'     => $request->barang_id,
            'jumlah'        => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan'    => $request->keterangan,
        ]);

        $barang = $barangMasuk->barang;
        $lastUrut = BarangUnit::getLastUrut($barang->id);

        for ($i = 1; $i <= $request->jumlah; $i++) {

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

        toast()->success('Barang masuk berhasil ditambahkan');

        return redirect()->route('master-data.barang-masuk.index');
    }

    public function update(UpdateBarangMasukReq $request, BarangMasuk $barangMasuk)
    {
        $barang = $barangMasuk->barang;
        $barang->decrement('stok', $barangMasuk->jumlah);
        $unitsLama = $barang->units()
            ->where('status', 'tersedia')
            ->latest()
            ->take($barangMasuk->jumlah)
            ->get();

        foreach ($unitsLama as $unit) {
            $unit->delete();
        }
        $barangMasuk->update([
            'barang_id'     => $request->barang_id,
            'jumlah'        => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan'    => $request->keterangan,
        ]);
        $barang->increment('stok', $request->jumlah);
        $totalUnit = $barang->units()->count();

        for ($i = 1; $i <= $request->jumlah; $i++) {

            $nomorUrut = $totalUnit + $i;

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

        toast()->success('Barang masuk berhasil diperbarui');

        return redirect()->route('master-data.barang-masuk.index');
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
            new BarangMasukExport(
                $tanggalAwal,
                $tanggalAkhir
            ),
            $namaFile
        );
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $barang = $barangMasuk->barang;
        $barang->decrement('stok', $barangMasuk->jumlah);
        $units = $barang->units()
            ->where('status', 'tersedia')
            ->latest()
            ->take($barangMasuk->jumlah)
            ->get();

        foreach ($units as $unit) {
            $unit->delete();
        }

        $barangMasuk->delete();

        toast()->success('Data barang masuk berhasil dihapus');

        return redirect()->route('master-data.barang-masuk.index');
    }
}