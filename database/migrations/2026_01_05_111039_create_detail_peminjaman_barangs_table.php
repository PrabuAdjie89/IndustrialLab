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
        Schema::create('detail_peminjaman_barangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_barang_id')
                ->constrained('peminjaman_barangs')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->restrictOnDelete();

            $table->integer('jumlah')->default(1);
            $table->string('surat_peminjaman');
            $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman_barangs');
    }
};
