<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerubahanModel extends Model
{
    use HasFactory;

    protected $table = 'log_perubahan';
    
    protected $fillable = [
        'id_distribusi',
        'tanggal_perubahan',
    ];

    // If you have timestamp fields like created_at and updated_at, Laravel will handle them automatically
    public $timestamps = false;
}
