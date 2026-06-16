<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE barang_units
            MODIFY status ENUM(
                'tersedia',
                'dipinjam',
                'rusak',
                'maintenance',
                'keluar'
            ) NOT NULL DEFAULT 'tersedia'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE barang_units
            MODIFY status ENUM(
                'tersedia',
                'dipinjam',
                'rusak',
                'maintenance'
            ) NOT NULL DEFAULT 'tersedia'
        ");
    }
};