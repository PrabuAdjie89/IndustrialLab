<?php

namespace App\View\Components\Peminjaman;

use App\Models\Barang;
use Illuminate\View\Component;

class FormPeminjaman extends Component
{
    public $barangs;

    public function __construct()
    {
        $this->barangs = Barang::where('bisa_dipinjam', true)
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();
    }

    public function render()
    {
        return view('components.peminjaman.form-peminjaman');
    }
}
