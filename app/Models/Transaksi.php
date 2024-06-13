<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'kd_user', 'id');
    }

    protected $fillable = [
        'tgl_transaksi', 'jml_total', 'jml_bayar', 'jml_kembali', 'kd_user', 'no_antrian'
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'kd_transaksi', 'kd_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang');
    }
}
