<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengeluaran;
use App\Models\Transaksi;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // }
    public function index()
    {
        // Fetch the data for barangs
        $barangs = Barang::with('kategori', 'stoks')->get(); // Assuming you have relationships defined in your model

        $pengeluaran = Pengeluaran::with(['user', 'kategori_pengeluaran']);

        // Calculate the sum of jml_pengeluaran
        $totalPengeluaran = $pengeluaran->sum('jml_pengeluaran');
        // Fetch the data for transactions for both users
        $user3Transactions = Transaksi::where('kd_user', 4)->get();
        $user4Transactions = Transaksi::where('kd_user', 5)->get();

        // Calculate the totals for user 3
        $user3Totals = [
            'jml_total' => $user3Transactions->sum('jml_total'),
            'jml_bayar' => $user3Transactions->sum('jml_bayar'),
            'jml_kembali' => $user3Transactions->sum('jml_kembali'),
            'total_transaksi' => $user3Transactions->count()
        ];

        // Calculate the totals for user 4
        $user4Totals = [
            'jml_total' => $user4Transactions->sum('jml_total'),
            'jml_bayar' => $user4Transactions->sum('jml_bayar'),
            'jml_kembali' => $user4Transactions->sum('jml_kembali'),
            'total_transaksi' => $user4Transactions->count()
        ];

        // Calculate the totals for all transactions (all users)
        $allTransactions = Transaksi::all();
        $jmlTotal = $allTransactions->sum('jml_total');
        $jmlBayar = $allTransactions->sum('jml_bayar');
        $jmlKembali = $jmlTotal - $totalPengeluaran;
        $totalTransaksi = $allTransactions->count();

        // Pass the data to the view
        return view('home', compact(
            'barangs',
            'pengeluaran',
            'totalPengeluaran',
            'user3Totals',
            'user4Totals',
            'jmlTotal',
            'jmlBayar',
            'jmlKembali',
            'totalTransaksi'
        ));
    }
}
