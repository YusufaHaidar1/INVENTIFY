<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_barang' => 1,
                'id_kode_barang' => 1,
                'id_user' => 1,
                'nama_barang' => 'Lemari Besi (Oxio)',
                'NUP' => '1',
                'harga_perolehan' => '150000',
                'tanggal_pencatatan' => now()
            ],
            [
                'id_barang' => 2,
                'id_kode_barang' => 1,
                'id_user' => 1,
                'nama_barang' => 'Lemari Besi (Oxio)',
                'NUP' => '2',
                'harga_perolehan' => '150000',
                'tanggal_pencatatan' => now()
            ]
        ];
        DB::table('detail_barang')->insert($data);
    }
}
