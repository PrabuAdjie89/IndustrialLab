<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarUnit extends Model
{
    protected $fillable = [
        'barang_keluar_id',
        'barang_unit_id',
        'kode_unit',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(
            BarangKeluar::class
        );
    }
    public function barangUnit()
    {
        return $this->belongsTo(
            BarangUnit::class
        );
    }
}