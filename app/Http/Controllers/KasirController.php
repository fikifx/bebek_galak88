<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        // Fetch the data for barangs
        $barangs = Barang::with('kategori', 'stoks')->get(); // Assuming you have relationships defined in your model

        // Fetch the data for pengeluaran
        $userId = Auth::id();
        $pengeluaran = Pengeluaran::with('kategori_pengeluaran')
            ->where('kd_user', $userId)
            ->get();


        // Pass the data to the view
        return view('kasir', compact(
            'barangs',
            'pengeluaran',
           
        ));
    }
}
