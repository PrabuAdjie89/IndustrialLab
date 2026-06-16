<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $fillable = ['nama_kategori'];
    use HasFactory;

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_barang_id');
    }

}

