<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBarangModel extends Model
{
    use HasFactory;

    protected $table = 'detail_kode_barang';
    protected $primaryKey = 'id_kode_barang';
    public $timestamps = false;

    protected $fillable = ['kode_barang', 'satuan', 'deskripsi_barang'];

}