<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AsetMasukController;
use App\Http\Controllers\AsetMutasiController;
use App\Http\Controllers\AsetPenghapusanController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailAsetController;
use App\Http\Controllers\DetailAsetMutasiController;
use App\Http\Controllers\DetailAsetPenghapusanController;
use App\Http\Controllers\InformasiAsetController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth', 'verified')->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // master data  
    Route::middleware(['access:sarpras'])->group(function () {
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/ruangan', RuanganController::class);
        Route::resource('/aset', AsetController::class);
    });


    // informasi aset
    Route::get('/informasi-aset/list', [InformasiAsetController::class, 'index'])->name('informasi_aset.index');
    Route::get('/informasi-aset/list-kelas', [InformasiAsetController::class, 'list_kelas'])->name('informasi_aset.list_kelas');
    Route::get('/informasi-aset/{id}/list-kelas', [InformasiAsetController::class, 'show'])->name('informasi_aset.show');
    Route::get('/informasi-aset/aset_dihapuskan', [InformasiAsetController::class, 'aset_dihapuskan'])->name('informasi_aset.aset_dihapuskan');

    // transaksi
    Route::resource('/aset_masuk', AsetMasukController::class);
    Route::resource('/detail_aset', DetailAsetController::class);
    Route::resource('/aset_mutasi', AsetMutasiController::class);
    Route::get('/get_detail_aset/aset_mutasi/{id}', [AsetMutasiController::class, 'get_detail_aset']);

    Route::resource('/detail_aset_mutasi', DetailAsetMutasiController::class);
    Route::resource('/aset_penghapusan', AsetPenghapusanController::class);
    Route::resource('/detail_aset_penghapusan', DetailAsetPenghapusanController::class);

    // LAPORAN
    Route::get('/laporan/aset-masuk', [LaporanController::class, 'laporan_masuk'])->name('laporan.aset_masuk');
    Route::get('/laporan/aset-mutasi', [LaporanController::class, 'laporan_mutasi'])->name('laporan.aset_mutasi');
    Route::get('/laporan/aset-dihapuskan', [LaporanController::class, 'laporan_dihapuskan'])->name('laporan.aset_dihapuskan');


    Route::get('/account', [RegisteredUserController::class, 'index_account_dashboard'])->name('account.index');
    Route::get('/account/create', [RegisteredUserController::class, 'create_account_dashboard'])->name('account.create');
    Route::post('/account/store', [RegisteredUserController::class, 'store']);
    Route::get('/account/{user}/edit', [RegisteredUserController::class, 'edit_account']);
    Route::put('/account/{id}', [RegisteredUserController::class, 'update_account']);
    Route::delete('/account/{id}', [RegisteredUserController::class, 'destroy_account']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
