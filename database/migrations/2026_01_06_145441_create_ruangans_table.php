<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->string('kode_ruangan')->unique();
            $table->string('nama_ruangan');
            $table->enum('status_ruangan', ['tersedia', 'dipakai', 'tidak_aktif'])
                  ->default('tersedia');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
