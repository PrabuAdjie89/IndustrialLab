<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';


    protected $fillable = [
        'kode_barang',  
        'kategori_barang_id',
        'nama_barang',
        'deskripsi_barang',
        'gambar',
        'bisa_dipinjam',
        'stok',
    ];

   
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public static function generateKode()
    {
        $lastKode = self::orderBy('id', 'desc')->value('kode_barang');

        if (!$lastKode) {
            return 'BRG-0001';
        }

        $number = (int) substr($lastKode, 4);
        $number++;

        return 'BRG-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjamanAlat::class);
    }

    public function units()
    {
        return $this->hasMany(BarangUnit::class);
    }
    public function detailBarang()
    {
        return $this->hasMany(BarangUnit::class, 'barang_id');
    }


    
    public function getStatusLabelAttribute()
    {
        return $this->bisa_dipinjam
            ? 'Bisa Dipinjam'
            : 'Tidak Bisa Dipinjam';
    }
}
