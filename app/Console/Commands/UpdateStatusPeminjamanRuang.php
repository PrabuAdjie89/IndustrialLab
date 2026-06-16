<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PeminjamanRuangan;
use Carbon\Carbon;

class UpdateStatusPeminjamanRuang extends Command
{
    protected $signature = 'peminjaman:update-status';
    protected $description = 'Update otomatis status peminjaman ruangan';

    public function handle()
    {
        $now = Carbon::now();

        $data = PeminjamanRuangan::where('status', 'disetujui')->get();

        foreach ($data as $item) {

            $mulai = Carbon::parse($item->tanggal . ' ' . $item->waktu_mulai);
            $selesai = Carbon::parse($item->tanggal . ' ' . $item->waktu_selesai);

            // 🔥 H-15 menit → dipakai
            if ($now >= $mulai->copy()->subMinutes(15) && $now < $selesai) {
                $item->update(['status' => 'dipakai']);
            }

            // 🔥 Setelah selesai → selesai
            if ($now >= $selesai) {
                $item->update(['status' => 'selesai']);
            }
        }

        return 0;
    }
}