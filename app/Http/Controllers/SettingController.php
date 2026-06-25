<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function sop()
    {
        $pageTitle = 'Pengaturan SOP';

        $sopBarang = Setting::firstOrCreate(
            ['key' => 'sop_peminjaman_barang'],
            ['value' => 'Belum ada SOP Peminjaman Barang']
        );

        $sopRuangan = Setting::firstOrCreate(
            ['key' => 'sop_peminjaman_ruangan'],
            ['value' => 'Belum ada SOP Peminjaman Ruangan']
        );

        return view(
            'setting.index',
            compact(
                'pageTitle',
                'sopBarang',
                'sopRuangan'
            )
        );
    }

    public function updateSop(Request $request)
    {
        $request->validate([
            'sop_barang'  => 'required',
            'sop_ruangan' => 'required',
        ]);

        Setting::updateOrCreate(
            ['key' => 'sop_peminjaman_barang'],
            ['value' => $request->sop_barang]
        );

        Setting::updateOrCreate(
            ['key' => 'sop_peminjaman_ruangan'],
            ['value' => $request->sop_ruangan]
        );

        toast()->success('SOP berhasil diperbarui');

        return back();
    }
}