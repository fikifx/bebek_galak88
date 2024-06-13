<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Stok;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class TransaksiController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'jml_total' => 'required|numeric',
            'jml_bayar' => 'required|numeric',
            'jml_kembali' => 'required|numeric',
            'kd_metode' => 'required|string',
        ]);

        $menu = json_decode($request->menu, true);
        $qty = json_decode($request->qty, true);

        DB::beginTransaction();

        try {
            $today = Carbon::today()->toDateString();
            $lastTransaction = Transaksi::whereDate('tgl_transaksi', $today)
                ->orderBy('no_antrian', 'desc')
                ->first();
            $no_antrian = $lastTransaction ? $lastTransaction->no_antrian + 1 : 1;

            $transaksi = new Transaksi();
            $transaksi->tgl_transaksi = $request->tgl_transaksi;
            $transaksi->jml_total = $request->jml_total;
            $transaksi->jml_bayar = $request->jml_bayar;
            $transaksi->jml_kembali = $request->jml_kembali;
            $transaksi->qty = $request->qty;
            $transaksi->menu = $request->menu;
            $transaksi->kd_user = Auth::id();
            $transaksi->kd_metode = $request->kd_metode;
            $transaksi->no_antrian = $no_antrian;
            $transaksi->save();

            foreach ($menu as $index => $namaMenu) {
                $barang = Barang::where('nm_barang', $namaMenu)->firstOrFail();

                $detailTransaksi = new DetailTransaksi();
                $detailTransaksi->kd_transaksi = $transaksi->id;
                $detailTransaksi->kd_barang = $barang->kd_barang;
                $detailTransaksi->quantity = $qty[$index];
                $detailTransaksi->save();

                $stok = Stok::where('kd_barang', $barang->kd_barang)->firstOrFail();
                if ($stok->jml_stok >= $qty[$index]) {
                    $stok->jml_stok -= $qty[$index];
                    $stok->save();
                } else {
                    return redirect()->route('kasir.index')->with('error', 'Stok Menu ' . $barang->nm_barang . ' Habis, Inputan Melebihi Jumlah Stok');
                }
            }

            DB::commit();
            return redirect()->route('invoice.show', ['kd_transaksi' => $transaksi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kasir.index')->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
        }
    }



    public function show($kd_transaksi)
    {
        $transaksi = Transaksi::where('kd_transaksi', $kd_transaksi)->first(); // Misalnya menggunakan Eloquent ORM

        // Pastikan $transaksi ditemukan sebelum menggunakan datanya
        if ($transaksi) {
            return view('invoice', compact('transaksi')); // Mengirimkan data transaksi ke halaman invoice
        } else {
        }
    }

    public function index(Request $request)
    {
        $allTransactions = Transaksi::query();

        if (!empty($request->minDate) && !empty($request->maxDate)) {
            $allTransactions->whereBetween('tgl_transaksi', [$request->minDate, $request->maxDate]);
        }

        $jmlTotal = $allTransactions->sum('jml_total');
        $jmlBayar = $allTransactions->sum('jml_bayar');
        $jmlKembali = $jmlBayar - $jmlTotal;
        $totalTransaksi = $allTransactions->count();

        if ($request->ajax()) {
            $query = Transaksi::with('user');

            if (!empty($request->minDate) && !empty($request->maxDate)) {
                $query->whereBetween('tgl_transaksi', [$request->minDate, $request->maxDate]);
            }

            $data = DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="action">
                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="lni lni-more-alt"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction' . $row->kd_transaksi . '">
                                    <li><a href="' . route('invoice.show', $row->kd_transaksi) . '" target="_blank" class="dropdown-item">Invoice</a></li>
                                </ul>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);

            $data = $data->getData(true);
            $data['jmlTotal'] = $jmlTotal;
            $data['jmlBayar'] = $jmlBayar;
            $data['jmlKembali'] = $jmlKembali;
            $data['totalTransaksi'] = $totalTransaksi;

            return response()->json($data);
        }

        return view('laporan', compact('jmlTotal', 'jmlBayar', 'jmlKembali', 'totalTransaksi'));
    }





    public function laporan()
    {
        return view('laporan'); // Assuming 'laporan' is the view for displaying the data table
    }

    public function cetak(Request $request)
    {
        $query = Transaksi::query();

        if ($request->has('minDate') && $request->has('maxDate')) {
            $query->whereBetween('tgl_transaksi', [$request->minDate, $request->maxDate]);
        }

        $transaksi = $query->get();
        $jmlTotal = $query->sum('jml_total');
        $jmlBayar = $query->sum('jml_bayar');
        $jmlKembali = $jmlBayar - $jmlTotal;

        return view('cetak', compact('transaksi', 'request', 'jmlTotal', 'jmlBayar', 'jmlKembali'));
    }



    public function destroy($kd_transaksi)
    {
        $transaksi = Transaksi::find($kd_transaksi);
        $transaksi->delete();

        return redirect()->route('laporan.transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }
}
