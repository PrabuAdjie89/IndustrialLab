<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function sop()
    {
        $pageTitle = 'Pengaturan SOP';

        $sop = Setting::firstOrCreate(
            ['key' => 'sop_peminjaman'],
            ['value' => 'Belum ada SOP']
        );

        return view(
            'setting.index',
            compact(
                'pageTitle',
                'sop'
            )
        );
    }

    public function updateSop(Request $request)
    {
        $request->validate([
            'sop' => 'required'
        ]);

        Setting::updateOrCreate(
            ['key' => 'sop_peminjaman'],
            ['value' => $request->sop]
        );

        toast()->success('SOP berhasil diperbarui');

        return back();
    }
}