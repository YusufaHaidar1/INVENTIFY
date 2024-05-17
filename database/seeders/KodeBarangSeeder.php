<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_kode_barang' => 1,
                'kode_barang' => '3050104001',
                'satuan' => 'Buah',
                'deskripsi_barang' => 'Lemari Besi / Metal'
            ],
            [
                'id_kode_barang' => 2,
                'kode_barang' => '3030101005',
                'satuan' => 'Buah',
                'deskripsi_barang' => 'Mesin Bor'
            ]
        ];
        DB::table('detail_kode_barang')->insert($data);
    }
}
