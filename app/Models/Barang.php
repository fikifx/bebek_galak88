<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    
    protected $primaryKey = 'kd_barang'; 
    
    public $incrementing = false; 
    protected $keyType = 'string'; 


    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kd_kategori', 'id');
    }

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'kd_barang', 'kd_barang');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'kd_barang', 'kd_barang');
    }
}
