<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barangs'; 

    protected $fillable = [
        'nm_kategori'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kd_kategori', 'id');
    }
}
