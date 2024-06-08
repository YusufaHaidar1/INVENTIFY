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
            Schema::table('detail_distribusi_barang', function (Blueprint $table) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id_distribusi'); // Add the new column
                $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade'); // Set up the foreign key
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_distribusi_barang', function (Blueprint $table) {
            $table->dropForeign(['id_user']); // Drop the foreign key
            $table->dropColumn('id_user'); // Drop the column
        });
    }
};
