<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBarang extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_barangs';

    protected $fillable = [
        'kode_peminjaman',
        'unit_peminjam',
        'nomor_telepon',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(
            DetailPeminjamanAlat::class,
            'peminjaman_barang_id'
        );
    }


    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->kode_peminjaman)) {
                $lastKode = self::orderByDesc('id')->value('kode_peminjaman');

                if (!$lastKode) {
                    $model->kode_peminjaman = 'PMJ-0001';
                } else {
                    $number = (int) substr($lastKode, 4) + 1;
                    $model->kode_peminjaman = 'PMJ-' . str_pad($number, 4, '0', STR_PAD_LEFT);
                }
            }

   
            $model->status = $model->status ?? 'menunggu';
        });
    }



    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Persetujuan',
            'dipinjam' => 'Sedang Dipinjam',
            'selesai'  => 'Dikembalikan',
            'ditolak'  => 'Ditolak',
            default    => '-',
        };
    }
}
