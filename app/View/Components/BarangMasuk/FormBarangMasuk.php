<?php

namespace App\View\Components\BarangMasuk;

use Closure;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormBarangMasuk extends Component
{
    public $id;
    public $barang_id;
    public $jumlah;
    public $tanggal_masuk;
    public $keterangan;
    public $barang;
    public $action;

    public function __construct($id = null)
    {
        // ambil semua barang
        $this->barang = Barang::orderBy('nama_barang')->get();

        if ($id) {
            $barangMasuk = BarangMasuk::findOrFail($id);

            $this->id            = $barangMasuk->id;
            $this->barang_id     = $barangMasuk->barang_id;
            $this->jumlah        = $barangMasuk->jumlah;
            $this->tanggal_masuk = $barangMasuk->tanggal_masuk;
            $this->keterangan    = $barangMasuk->keterangan;

            $this->action = route('master-data.barang-masuk.update', $barangMasuk->id);
        } else {
            $this->tanggal_masuk = now()->format('Y-m-d');
            $this->action        = route('master-data.barang-masuk.store');
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.barang-masuk.form-barang-masuk');
    }
}
