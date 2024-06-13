<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluran;
use App\Models\Pengeluaran;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pengeluaran = Pengeluaran::with(['user', 'kategori_pengeluaran']);
        if ($request->ajax()) {
            $query = Pengeluaran::with(['user', 'kategori_pengeluaran']);

            if (!empty($request->minDate) && !empty($request->maxDate)) {
                $query->whereBetween('tgl_pengeluaran', [$request->minDate, $request->maxDate]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn text-danger btn-delete" data-id="' . $row->id . '" data-name="' . $row->nm_pengeluaran . '"><i class="lni lni-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pengeluaran.laporan-pengeluaran.index', compact('pengeluaran'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori_pengeluaran = KategoriPengeluran::all();
        $user = User::all();
        return view('pengeluaran.laporan-pengeluaran.create', compact('kategori_pengeluaran', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nm_pengeluaran' => 'required|string',
                'kd_kategori_pengeluaran' => 'required|integer',
                'tgl_pengeluaran' => 'required',
                'jml_pengeluaran' => 'required',
            ]);



            $pengeluaran = new Pengeluaran();
            $pengeluaran->nm_pengeluaran = $request->nm_pengeluaran;
            $pengeluaran->catatan = $request->catatan;
            $pengeluaran->kd_kategori_pengeluaran = $request->kd_kategori_pengeluaran;
            $pengeluaran->tgl_pengeluaran = $request->tgl_pengeluaran;
            $pengeluaran->jml_pengeluaran = $request->jml_pengeluaran;
            $pengeluaran->kd_user = Auth::id();
            $pengeluaran->save();

            return redirect()->route('laporan-pengeluaran.create')->with('success', 'Tambah pengeluaran berhasil');
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

    public function laporan()
    {
        return view('pengeluaran.laporan-pengeluaran.index');
    }


    public function cetak(Request $request)
    {
        $query = Pengeluaran::with(['user', 'kategori_pengeluaran']);

        if ($request->has('minDate') && $request->has('maxDate')) {
            $query->whereBetween('tgl_pengeluaran', [$request->minDate, $request->maxDate]);
        }

        $pengeluaran = $query->get();

        return view('pengeluaran.laporan-pengeluaran.cetak', compact('pengeluaran', 'request'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        // Lakukan proses penghapusan Pengel$pengeluaran
        $pengeluaran->delete();

        return redirect()->route('laporan-pengeluaran.index')->with('success', 'Berhasil menghapus.');
    }
}
