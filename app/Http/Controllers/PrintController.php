<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class PrintController extends Controller
{
    public function cetakInvoice($id)
    {
        // Mengambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Mengirimkan data transaksi ke view untuk dicetak
        return view('cetak.invoice', compact('transaksi'));
    }
}
