<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanBarangExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new BarangSheetExport(),
            new DetailBarangSheetExport(),
        ];
    }
}