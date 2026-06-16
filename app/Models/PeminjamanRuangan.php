<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // 

class PeminjamanRuangan extends Model
{
    protected $table = 'peminjaman_ruangans';

    protected $fillable = [
        'user_id',
        'ruangan_id',
        'nama_peminjam',
        'nama_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    /**
     *  APPEND otomatis ke object 
     */
    protected $appends = ['status_realtime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id_ruangan');
    }

    /**
     *  REALTIME STATUS LOGIC
     */
    public function getStatusRealtimeAttribute()
    {
        $now = Carbon::now();

        $mulai = Carbon::parse($this->tanggal . ' ' . $this->waktu_mulai);
        $selesai = Carbon::parse($this->tanggal . ' ' . $this->waktu_selesai);

        // kalau ditolak → tetap
        if ($this->status === 'ditolak') {
            return 'ditolak';
        }

        // kalau selesai → tetap
        if ($this->status === 'selesai') {
            return 'selesai';
        }

        // 🔥 AUTO LOGIC (backup kalau cron belum jalan)
        if ($this->status === 'disetujui') {

            if ($now >= $selesai) {
                return 'selesai';
            }

            if ($now >= $mulai->copy()->subMinutes(15)) {
                return 'dipakai';
            }

            return 'disetujui';
        }

        return $this->status;
    }
   
    // public function getStatusRealtimeAttribute()
    // {
    //     // kalau belum disetujui
    //     if ($this->status !== 'disetujui') {
    //         return $this->status;
    //     }

    //     $now = Carbon::now();

    //     $mulai = Carbon::parse($this->tanggal . ' ' . $this->waktu_mulai);
    //     $selesai = Carbon::parse($this->tanggal . ' ' . $this->waktu_selesai);

    //     // 1 jam sebelum mulai
    //     $mulaiMinus1Jam = $mulai->copy()->subHour();

    //     //  sudah lewat
    //     if ($now >= $selesai) {
    //         return 'selesai';
    //     }

    //     //  sedang berlangsung (atau H-1 jam)
    //     if ($now >= $mulaiMinus1Jam && $now < $selesai) {
    //         return 'dipakai';
    //     }

    //     //  masih menunggu waktu
    //     return 'disetujui';
    // }
}