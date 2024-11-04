<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_ikan',
        'harga_ikan',
        'jumlah_ikan',
        'foto_ikan',
        'deskripsi_ikan',
        'habitat_ikan',
    ];
}
