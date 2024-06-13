<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::all();
        return view('from', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kd_stok)
    {
        try {
            // Validasi input
            $request->validate([
                'kd_barang' => 'required|string',
                'jml_stok' => 'required|integer',
            ]);

            // Mencari stok berdasarkan kd_stok
            $stok = Stok::where('kd_stok', $kd_stok)->first();

            if ($stok) {
                // Jika stok sudah ada, update jumlah stok
                $stok->kd_barang = $request->kd_barang;
                $stok->jml_stok = $request->jml_stok;
                $stok->save();
            } else {
                // Jika stok belum ada, tambahkan stok baru
                $stokBaru = new Stok();
                $stokBaru->kd_stok = $kd_stok;
                $stokBaru->kd_barang = $request->kd_barang;
                $stokBaru->jml_stok = $request->jml_stok;
                $stokBaru->save();
            }

            // Memperbarui informasi barang jika diperlukan
            $barang = Barang::where('kd_barang', $request->kd_barang)->first();
            if ($barang) {
                // Perbarui informasi barang jika ada perubahan
                // $barang->nama_atribut = $request->input('nama_atribut'); // Perbarui atribut sesuai kebutuhan
                $barang->save();
            }

            // Redirect dengan pesan sukses
            return redirect()->route('from.index')->with('success', 'Perbarui stok berhasil');
        } catch (QueryException $e) {
            // Tampilkan pesan error dari database query
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui stok. Error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Tampilkan pesan error umum
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui stok. Error: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
