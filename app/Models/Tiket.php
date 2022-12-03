<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tiket', 
        'nama_konser',
        'tanggal_konser',
        'waktu_konser', 
        'nama_penyanyi', 
        'harga', 
        'stok',
        'tempat_duduk',
        'alamat', 
        'panggung', 
        'ketersediaan'  
    ];

}
