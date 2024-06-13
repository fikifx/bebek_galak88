<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis';

    protected $fillable = [
        'kd_barang', 'kd_transaksi', 'quantity'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kd_transaksi', 'kd_transaksi');
    }
}
