<?php

namespace App\View\Components\PeminjamanRuang;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EportPeminjamanRuang extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.peminjaman-ruang.form-exportpeminjamanRuang');
    }
}