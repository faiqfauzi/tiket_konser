<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'jumlah_tiket',
        'harga_tiket',
        'total_harga',
        'nama_konser',
        'alamat_konser',
        'tanggal_konser',
        'pajak',
    ];

}
