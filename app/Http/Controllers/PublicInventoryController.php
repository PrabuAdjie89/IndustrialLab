<?php

namespace App\Http\Controllers;

use App\Models\BarangUnit;

class PublicInventoryController extends Controller
{
    public function show($kode_unit)
    {
        $unit = BarangUnit::with('barang')
            ->where('kode_unit', $kode_unit)
            ->firstOrFail();

        return view('inventory.public-show', [
            'unit' => $unit,
            'pageTitle' => 'Detail Inventaris'
        ]);
    }
}