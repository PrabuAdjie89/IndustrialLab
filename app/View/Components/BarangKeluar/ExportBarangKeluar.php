<?php

namespace App\View\Components\BarangKeluar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExportBarangKeluar extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.barang-keluar.form-export-barangkeluar');
    }
}