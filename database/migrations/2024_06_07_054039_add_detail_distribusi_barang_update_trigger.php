<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER detail_distribusi_barang_update_trigger
            AFTER UPDATE ON detail_distribusi_barang
            FOR EACH ROW
            BEGIN
            IF OLD.id_detail_status_akhir != NEW.id_detail_status_akhir THEN
                INSERT INTO log_perubahan (id_distribusi, tanggal_perubahan, status_akhir)
                VALUES (NEW.id_distribusi, NOW(), CASE NEW.id_detail_status_akhir
                                                    WHEN 1 THEN "Baik"
                                                    WHEN 2 THEN "Rusak Ringan"
                                                    WHEN 3 THEN "Rusak Berat"
                                                    ELSE NULL
                END);
        END IF;
    END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS detail_distribusi_barang_update_trigger');
    }
};
