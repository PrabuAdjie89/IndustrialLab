<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar_units', function (
            Blueprint $table
        ) {

            $table->id();

            $table->foreignId('barang_keluar_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger(
                'barang_unit_id'
            );

            $table->string(
                'kode_unit'
            );

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'barang_keluar_units'
        );
    }
};