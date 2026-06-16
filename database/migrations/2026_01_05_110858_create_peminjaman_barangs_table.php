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
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('unit_peminjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['ditolak','menunggu','dipinjam', 'selesai'])->default('menunggu');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};
