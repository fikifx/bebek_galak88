<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayarans'; 

    protected $fillable = [
        'nm_metode_pembayaran'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kd_metode_pembayaran', 'id');
    }
}
