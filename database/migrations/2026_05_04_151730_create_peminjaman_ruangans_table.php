<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_ruangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ruangan_id')->constrained('ruangans', 'id_ruangan')->cascadeOnDelete();
            $table->string('nama_peminjam'); 
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'selesai'
            ])->default('menunggu');

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_ruangans');
    }
};
