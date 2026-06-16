<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'ruangans';
    protected $primaryKey = 'id_ruangan';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'status_ruangan',
    ];

    public function peminjamanRuangs()
    {
        return $this->hasMany(
            PeminjamanRuangan::class,
            'id_ruangan',
            'id_ruangan'
        );
    }

    public static function generateKode(): string
    {
        $last = self::orderBy('id_ruangan', 'desc')->first();

        $number = $last
            ? intval(substr($last->kode_ruangan, 2)) + 1
            : 1;

        return 'R-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    // public function getStatusRealtimeAttribute()
    // {
    //     $now = now()->format('H:i');
    //     $today = now()->toDateString();

    //     $dipakai = $this->peminjaman()
    //         ->where('tanggal', $today)
    //         ->where('status', 'disetujui')
    //         ->whereTime('waktu_mulai', '<=', $now)
    //         ->whereTime('waktu_selesai', '>=', $now)
    //         ->exists();

    //     if ($dipakai) {
    //         return 'dipakai';
    //     }

    //     return $this->status_ruangan;
    // }

}
