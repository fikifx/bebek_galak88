<?php

use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PrintController;
use App\Models\Pengeluaran;
use Spatie\Permission\Middlewares\PermissionMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Menu Route
Route::get('from', [\App\Http\Controllers\BarangController::class, 'index'])->name('from.index')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('from/tambah-menu', [\App\Http\Controllers\BarangController::class, 'store'])->name('from.store')->middleware(['auth', 'verified', 'role:super-admin']);
Route::post('from/update-menu/{kd_barang}', [\App\Http\Controllers\BarangController::class, 'update'])->name('from.update')->middleware(['auth', 'verified', 'role:super-admin']);
Route::delete('from/hapus-menu/{kd_barang}', [\App\Http\Controllers\BarangController::class, 'destroy'])->name('from.destroy')->middleware(['auth', 'verified', 'role:super-admin']);

// Stok Route
Route::post('/stok/{kd_stock}', [\App\Http\Controllers\StockController::class, 'update'])->name('stok.update')->middleware(['auth', 'verified', 'role:super-admin']);

// Kategori Barang Route
Route::resource('/kategori', \App\Http\Controllers\KategoriBarangController::class)->middleware(['auth', 'verified', 'role:super-admin']);

// Users Route
Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware(['auth', 'verified', 'role:super-admin']);
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware(['auth', 'verified', 'role:super-admin']);
Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware(['auth', 'verified', 'role:super-admin']);
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'verified', 'role:super-admin']);

// Profile
Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware(['auth', 'verified', 'role:super-admin']);


Route::view('invoice', 'invoice')->name('invoice')->middleware(['auth', 'verified', 'role:super-admin|kasir']);

// Tranaksi Route
Route::post('transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('/transaksi/{kd_transaksi}/detail', [TransaksiController::class, 'showDetail'])->name('transaksi.detail')->middleware(['auth', 'verified', 'role:super-admin']);
Route::delete('/transaksi/{kd_transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.delete')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('/invoice/{kd_transaksi}', [TransaksiController::class, 'show'])->name('invoice.show')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('/transaksi/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak')->middleware(['auth', 'verified', 'role:super-admin|kasir']);

//Pengeluaran Kategori Route
Route::get('/pengeluaran', [KategoriPengeluaranController::class, 'index'])->name('pengeluaran.index')->middleware(['auth', 'verified', 'role:super-admin']);
Route::post('/pengeluaran/store', [KategoriPengeluaranController::class, 'store'])->name('pengeluaran.store')->middleware(['auth', 'verified', 'role:super-admin']);
Route::post('/pengeluaran/ubah/{id}', [KategoriPengeluaranController::class, 'update'])->name('pengeluaran.update')->middleware(['auth', 'verified', 'role:super-admin']);
Route::delete('/pengeluaran/delete/{id}', [KategoriPengeluaranController::class, 'destroy'])->name('pengeluaran.destroy')->middleware(['auth', 'verified', 'role:super-admin']);

Route::get('/detail-transaksi', [DetailTransaksiController::class, 'index'])->name('detail-transaksi.index')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('/laporan-detail-transaksi', [DetailTransaksiController::class, 'laporan'])->name('detail-transaksi.laporan')->middleware(['auth', 'verified', 'role:super-admin']);;

//Laporan Pengeluarn Route
Route::get('laporan-pengeluaran', [PengeluaranController::class, 'index'])->name('laporan-pengeluaran.index')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::get('laporan-pengeluaran/create', [PengeluaranController::class, 'create'])->name('laporan-pengeluaran.create')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::post('laporan-pengeluaran/store', [PengeluaranController::class, 'store'])->name('laporan-pengeluaran.store')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::delete('laporan-pengeluaran/destroy/{id}', [PengeluaranController::class, 'destroy'])->name('laporan-pengeluaran.destroy')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('laporan-pengeluaran/store', [PengeluaranController::class, 'store'])->name('laporan-pengeluaran.store')->middleware(['auth', 'verified', 'role:super-admin|kasir']);
Route::delete('laporan-pengeluaran/laporan', [PengeluaranController::class, 'laporan'])->name('laporan-pengeluaran.laporan')->middleware(['auth', 'verified', 'role:super-admin']);
Route::get('laporan-pengeluaran/cetak', [PengeluaranController::class, 'cetak'])->name('laporan-pengeluaran.cetak')->middleware(['auth', 'verified', 'role:super-admin']);

//Kasir route
Route::get('kasir', [\App\Http\Controllers\KasirController::class, 'index'])->name('kasir.index')->middleware(['auth', 'verified', 'role:super-admin|kasir']);

Route::get('/pembayaran', [MetodePembayaranController::class, 'index'])->name('pembayaran.index');
Route::post('/pembayaran/store', [MetodePembayaranController::class, 'store'])->name('pembayaran.store');
Route::post('/pembayaran/update/{id}', [MetodePembayaranController::class, 'update'])->name('pembayaran.update');
Route::delete('/pembayaran/destroy/{id}', [MetodePembayaranController::class, 'destroy'])->name('pembayaran.destroy');
