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
        Schema::create('detail_kode_barang', function (Blueprint $table) {
            $table->id('id_kode_barang');
            $table->string('kode_barang')->unique();
            $table->string('satuan');
            $table->string('deskripsi_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kode_barang');
    }
};
