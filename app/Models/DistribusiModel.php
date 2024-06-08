<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistribusiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_distribusi_barang';
    protected $primaryKey = 'id_distribusi';
    public $timestamps = false;

    protected $fillable = ['id_barang', 'id_ruang', 'id_detail_status_awal', 'id_detail_status_akhir', 'id_user'];

    public function ruang(): BelongsTo{
        return $this->belongsTo(RuangModel::class, 'id_ruang', 'id_ruang');
    }

    public function barang(): BelongsTo{
        return $this->belongsTo(BarangModel::class, 'id_barang', 'id_barang');
    }

    public function statusAwal(): BelongsTo{
        return $this->belongsTo(StatusModel::class, 'id_detail_status_awal', 'id_detail_status');
    }

    public function statusAkhir(): BelongsTo{
        return $this->belongsTo(StatusModel::class, 'id_detail_status_akhir', 'id_detail_status');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }
}