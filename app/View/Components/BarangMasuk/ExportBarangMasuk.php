<?php

namespace App\View\Components\BarangMasuk;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExportBarangMasuk extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.barang-masuk.form-export-barangmasuk');
    }
}