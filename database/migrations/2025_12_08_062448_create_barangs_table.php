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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id')->nullable()->constrained('kategori_barangs')->nullOnDelete();
            $table->string('kode_barang', 10)->unique();
            $table->string('nama_barang');
            $table->text('deskripsi_barang')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('bisa_dipinjam')->default(true);
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('bisa_dipinjam');
        });
    }
};
