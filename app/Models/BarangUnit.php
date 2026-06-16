<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class BarangUnit extends Model
{
    use HasFactory;

    protected $table = 'barang_units';

    protected $fillable = [
        'barang_id',
        'kode_unit',
        'status',
        'kondisi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public static function generateKodeUnit($kodeBarang, $nomorUrut)
    {
        $tahun = date('y');

        return $kodeBarang . '-' .
            $tahun . '-' .
            str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
    }

    public static function getLastUrut($barangId)
    {
        $units = self::where('barang_id', $barangId)->get();

        if ($units->isEmpty()) {
            return 0;
        }

        $lastUrut = 0;

        foreach ($units as $unit) {

            $parts = explode('-', $unit->kode_unit);

            $nomor = (int) end($parts);

            if ($nomor > $lastUrut) {
                $lastUrut = $nomor;
            }
        }

        return $lastUrut;
    }
}