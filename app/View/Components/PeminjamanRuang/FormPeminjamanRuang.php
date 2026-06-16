<?php

namespace App\View\Components\PeminjamanRuang;

use App\Models\Ruangan;
use Illuminate\View\Component;

class FormPeminjamanRuang extends Component
{
    public $ruangans;

    public function __construct()
    {
        $this->ruangans = Ruangan::where('status_ruangan', 'tersedia')
            ->orderBy('nama_ruangan')
            ->get();
    }

    public function render()
    {
        return view('components.peminjaman-ruang.form-peminjaman-ruang');
    }
}