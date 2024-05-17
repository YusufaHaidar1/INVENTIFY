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
        Schema::create('detail_distribusi_barang', function (Blueprint $table) {
            $table->id('id_distribusi');
            $table->unsignedBigInteger('id_barang')->index()->unique();
            $table->unsignedBigInteger('id_ruang')->index();
            $table->unsignedBigInteger('id_detail_status_awal')->index();
            $table->unsignedBigInteger('id_detail_status_akhir')->index();

            $table->foreign('id_barang')->references('id_barang')->on('detail_barang');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang');
            $table->foreign('id_detail_status_awal')->references('id_detail_status')->on('detail_status_barang');
            $table->foreign('id_detail_status_akhir')->references('id_detail_status')->on('detail_status_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_distribusi_barang');
    }
};
