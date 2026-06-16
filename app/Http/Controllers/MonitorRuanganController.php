<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\PeminjamanRuangan;
use Carbon\Carbon;

class MonitorRuanganController extends Controller
{
    public function monitor()
    {
        $pageTitle = 'Monitor Jadwal Ruangan';

        $jadwalHariIni = PeminjamanRuangan::with('ruangan')

            // tanggal hari ini
            ->whereDate('tanggal', Carbon::today())

            // hanya yg tampil di monitor
            ->whereIn('status', ['disetujui', 'dipakai'])

            // urut jam mulai
            ->orderBy('waktu_mulai')

            ->get();

        return view('peminjaman-ruang.monitor',
            compact(
                'pageTitle',
                'jadwalHariIni'
            )
        );
    }
}
