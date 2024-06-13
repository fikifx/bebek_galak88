<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Stok;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('stoks')->get();
        $kategori = KategoriBarang::all();
        return view('from', compact('barangs', 'kategori'));
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
        try {
            $request->validate([
                'nm_barang' => 'required|string',
                'hrg_barang' => 'required',
                'kd_kategori' => 'required',
               
            ]);

            $barang = new Barang();
            $barang->nm_barang = $request->nm_barang;
            $barang->hrg_barang = $request->hrg_barang;
            $barang->kd_kategori = $request->kd_kategori;
         
            $barang->save();

            return redirect()->route('from.index')->with('success', 'Tambah menu berasil');
        } catch (QueryException $e) {

            return back()->withInput()->withErrors(['error' => 'Gagal menambah menu. Coba lagi sekarang.']);
        } catch (\Exception $e) {

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
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
    public function update(Request $request, string $kd_barang)
    {
        try {
          
            $barang = Barang::findOrFail($kd_barang);
            $barang->nm_barang = $request->nm_barang;
            $barang->hrg_barang = $request->hrg_barang;
            $barang->kd_kategori = $request->kd_kategori;
            $barang->save();
    
            return redirect()->route('from.index')->with('success', 'Menu berhasil diperbarui');
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui menu. Silakan coba lagi nanti.']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kd_barang)
    {
        try {
          
            $barang = Barang::findOrFail($kd_barang);
            $barang->stoks()->delete();
            $barang->delete();
    
            return redirect()->route('from.index')->with('success', 'Menu berhasil dihapus');
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui menu. Silakan coba lagi nanti.']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
