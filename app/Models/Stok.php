<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';
    protected $primaryKey = 'kd_stok'; // pastikan kolom ini benar
    protected $fillable = [
        'kd_barang', 'jml_stok'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang'); // pastikan kolom yang direferensikan benar
    }
}
