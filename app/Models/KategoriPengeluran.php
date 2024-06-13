<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengeluran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengelurans'; 

    protected $fillable = [
        'nm_kategori_pengeluaran'
    ];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'kd_kategori_pengeluaran', 'id');
    }
}
