<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal mulai dan tanggal akhir dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query barang
        $barangs = Barang::all();

        // Query penjualan dengan filter tanggal
        $penjualanQuery = DetailTransaksi::query();

        if ($startDate && $endDate) {
            $penjualanQuery->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
            });
        }

        $penjualan = $penjualanQuery->select('kd_barang', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('kd_barang')
            ->pluck('total_quantity', 'kd_barang');

        return view('laporan-items.index', compact('barangs', 'penjualan', 'startDate', 'endDate'));
    }

    public function laporan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query penjualan dengan filter tanggal dan join ke tabel Barang
        $penjualanQuery = DetailTransaksi::query();

        if ($startDate && $endDate) {
            $penjualanQuery->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
            });
        }

        $penjualan = $penjualanQuery->with('barang')
            ->select('kd_barang', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('kd_barang')
            ->get();

        $totalTransaksi = $penjualan->sum(function ($detail) {
            return $detail->total_quantity * $detail->barang->hrg_barang;
        });

        $barangs = Barang::all();

        return view('laporan-items.print', compact('barangs', 'penjualan', 'totalTransaksi', 'startDate', 'endDate'));
    }
}
