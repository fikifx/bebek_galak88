<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metode_pembayaran = MetodePembayaran::all();
        return view('pembayaran.index', compact('metode_pembayaran'));
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
                'nm_metode_pembayaran' => 'required|string',
            ]);

            $metode_pembayaran = new MetodePembayaran();
            $metode_pembayaran->nm_metode_pembayaran = $request->nm_metode_pembayaran;
            $metode_pembayaran->save();

            return redirect()->route('pembayaran.index')->with('success', 'Tambah metode pembayaran berhasil');
        } catch (QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create metode. Please try again later.']);
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
                'nm_metode_pembayaran' => 'required|string',
            ]);

            $metode_pembayaran = MetodePembayaran::findOrFail($id);
            $metode_pembayaran->nm_metode_pembayaran = $request->nm_metode_pembayaran;
            $metode_pembayaran->save();

            return redirect()->route('pembayaran.index')->with('success', 'Metode pembayaran berasil diperbarui');
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
            $metode_pembayaran = MetodePembayaran::findOrFail($id);

            $metode_pembayaran->delete();

            return redirect()->route('pembayaran.index')->with('success', 'Hapus Metode Pembayaran Berhasil');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
