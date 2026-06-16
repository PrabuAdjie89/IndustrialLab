<?php

namespace App\View\Components\BarangKeluar;

use Closure;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormBarangKeluar extends Component
{
    public $id;
    public $barang;
    public $barang_id;
    public $jumlah;
    public $tanggal_keluar;
    public $keterangan;
    public $action;

    public function __construct($id = null)
    {
        // ambil semua barang
        $this->barang = Barang::select('id', 'kode_barang', 'nama_barang', 'stok')->get();

        if ($id) {
            $barangKeluar = BarangKeluar::findOrFail($id);

            $this->id             = $barangKeluar->id;
            $this->barang_id      = $barangKeluar->barang_id;
            $this->jumlah         = $barangKeluar->jumlah;
            $this->tanggal_keluar = $barangKeluar->tanggal_keluar;
            $this->keterangan     = $barangKeluar->keterangan;

            $this->action = route('master-data.barang-keluar.update', $barangKeluar->id);
        } else {
            $this->jumlah         = 1;
            $this->tanggal_keluar = now()->format('Y-m-d');
            $this->action         = route('master-data.barang-keluar.store');
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.barang-keluar.form-barang-keluar');
    }
}
