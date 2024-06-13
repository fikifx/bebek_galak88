<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $kategori = KategoriBarang::all();
        return view('from');
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
                'nm_kategori' => 'required|string',
            ]);

            $kategori = new KategoriBarang;
            $kategori->nm_kategori = $request->nm_kategori;
            $kategori->save();

            return redirect()->route('from.index')->with('success', 'Tambah kategory berasil');
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
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nm_kategori' => 'required|string',
            ]);

            $kategori = KategoriBarang::findOrFail('id');
            $kategori->nm_kategori = $request->nm_kategori;
            $kategori->save();

            return redirect()->route('from')->with('success', 'Kategori berasil diperbarui');
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
        //
    }
}
