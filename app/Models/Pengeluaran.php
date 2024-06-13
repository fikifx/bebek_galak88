<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans'; 

    protected $fillable = [
        'nm_pengeluaran', 'kd_kategori_pengeluaran', 'tgl_pengeluaran', 'jml_pengeluaran', 'kd_user'
    ];

    public function kategori_pengeluaran()
    {
        return $this->belongsTo(KategoriPengeluran::class, 'kd_kategori_pengeluaran', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'kd_user', 'id');
    }
}
