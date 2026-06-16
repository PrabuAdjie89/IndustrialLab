<?php

namespace App\View\Components\Barang;

use Closure;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormBarang extends Component
{
    public $id;
    public $kode_barang;
    public $nama_barang;
    public $deskripsi_barang;
    public $gambar;
    public $stok;
    public $bisa_dipinjam;
    public $kategori_barang_id;
    public $kategori;
    public $action;

    public function __construct($id = null)
    {
        // ambil semua kategori
        $this->kategori = KategoriBarang::all();

        if ($id) {
            $barang = Barang::findOrFail($id);

            $this->id                  = $barang->id;
            $this->kode_barang         = $barang->kode_barang;
            $this->nama_barang         = $barang->nama_barang;
            $this->deskripsi_barang    = $barang->deskripsi_barang;
            $this->gambar              = $barang->gambar;
            $this->stok                = $barang->stok;
            $this->bisa_dipinjam       = $barang->bisa_dipinjam;
            $this->kategori_barang_id  = $barang->kategori_barang_id;

            $this->action = route('master-data.barang.update', $barang->id);
        } else {
            $this->stok          = 0;
            $this->bisa_dipinjam = 1;
            $this->action        = route('master-data.barang.store');
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.barang.form-barang');
    }
}
