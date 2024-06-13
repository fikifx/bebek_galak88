<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $kategori_pengeluaran = KategoriPengeluran::all();
        return view('pengeluaran.kategori.index', compact('kategori_pengeluaran'));
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
                'nm_kategori_pengeluaran' => 'required|string',
            ]);

            $kategori_pengeluaran = new KategoriPengeluran();
            $kategori_pengeluaran->nm_kategori_pengeluaran = $request->nm_kategori_pengeluaran;
            $kategori_pengeluaran->save();

            return redirect()->route('pengeluaran.index')->with('success', 'Tambah kategory pengeluaran berhasil');
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create user. Please try again later.']);
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
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nm_kategori_pengeluaran' => 'required|string',
            ]);

            $kategori_pengeluaran = KategoriPengeluran::findOrFail($id);
            $kategori_pengeluaran->nm_kategori_pengeluaran = $request->nm_kategori_pengeluaran;
            $kategori_pengeluaran->save();

            return redirect()->route('pengeluaran.index')->with('success', 'Kategori pengeluran berasil diperbarui');
        } catch (QueryException $e) {

            return back()->withInput()->withErrors(['error' => 'Failed to create user. Please try again later.']);
        } catch (\Exception $e) {

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori_pengeluaran = KategoriPengeluran::findOrFail($id);

            $kategori_pengeluaran->delete();

            return redirect()->route('pengeluaran.index')->with('success', 'Hapus Kategori Pengeluaran Berhasil');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
