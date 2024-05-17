<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_distribusi' => 1,
                'id_barang' => 1,
                'id_ruang' => 1,
                'id_detail_status_awal' => 1,
                'id_detail_status_akhir' => 1,
            ],
            [
                'id_distribusi' => 2,
                'id_barang' => 2,
                'id_ruang' => 1,
                'id_detail_status_awal' => 1,
                'id_detail_status_akhir' => 1,
            ],
        ];
        DB::table('detail_distribusi_barang')->insert($data);
    }
}
