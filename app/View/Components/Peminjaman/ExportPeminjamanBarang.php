<?php

namespace App\View\Components\Peminjaman;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EportPeminjamanBarang extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.peminjaman.form-exportpeminjamanbarang');
    }
}