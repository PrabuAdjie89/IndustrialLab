<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjamanAlat extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman_barangs';

    protected $fillable = [
        'peminjaman_barang_id',
        'barang_id',
        'jumlah',
        'surat_peminjaman',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function peminjaman()
    {
        return $this->belongsTo(
            PeminjamanBarang::class,
            'peminjaman_barang_id'
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_id',
            'id'
        );
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjamanAlat::class);
    }
}
