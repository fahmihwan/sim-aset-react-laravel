<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AsetMasukController;
use App\Http\Controllers\AsetMutasiController;
use App\Http\Controllers\AsetPenghapusanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailAsetController;
use App\Http\Controllers\DetailAsetMutasiController;
use App\Http\Controllers\DetailAsetPenghapusanController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\InformasiAsetController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PemeliharaanController;
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

Route::get('/', [AuthenticatedSessionController::class, 'create']);


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
    Route::post('/get_search_aset_saatini', [InformasiAsetController::class, 'get_search_aset_saatini']);

    Route::get('/informasi-aset/list-kelas', [InformasiAsetController::class, 'list_kelas'])->name('informasi_aset.list_kelas');
    Route::get('/informasi-aset/{id}/list-kelas', [InformasiAsetController::class, 'show'])->name('informasi_aset.show');
    Route::get('/informasi-aset/aset_dihapuskan', [InformasiAsetController::class, 'aset_dihapuskan'])->name('informasi_aset.aset_dihapuskan');

    // transaksi
    Route::resource('/aset_masuk', AsetMasukController::class);
    Route::resource('/detail_aset', DetailAsetController::class);
    Route::resource('/aset_mutasi', AsetMutasiController::class);
    Route::get('/get_detail_aset/aset_mutasi/{id}', [AsetMutasiController::class, 'get_detail_aset']);
    Route::get('/get_detail_aset_for_penghapusan/aset_mutasi/{id}', [AsetMutasiController::class, 'get_detail_aset_for_penghapusan']);


    Route::resource('/detail_aset_mutasi', DetailAsetMutasiController::class);
    Route::resource('/aset_penghapusan', AsetPenghapusanController::class);
    Route::resource('/detail_aset_penghapusan', DetailAsetPenghapusanController::class);

    Route::get("/aset_pemeliharaan", [PemeliharaanController::class, 'index'])->name('aset_pemeliharaan.index');
    Route::get("/aset_pemeliharaan/create", [PemeliharaanController::class, 'create'])->name('aset_pemeliharaan.create');;
    Route::get("/aset_pemeliharaan/{id}", [PemeliharaanController::class, 'show'])->name('aset_pemeliharaan.show');
    Route::put("/aset_pemeliharaan/{id}", [PemeliharaanController::class, 'update'])->name('aset_pemeliharaan.update');
    Route::post("/aset_pemeliharaan", [PemeliharaanController::class, 'store'])->name('aset_pemeliharaan.store');
    Route::delete('/aset_pemeliharaan/{id}', [PemeliharaanController::class, 'destroy'])->name('aset_pemeliharaan.destroy');
    Route::post('/store_detail_pemeliharaan', [PemeliharaanController::class, 'store_detail_pemeliharaan'])->name('aset_pemeliharaan.store_detail_pemeliharaan');
    Route::delete('/destroy_detail_pemeliharaan/{id}', [PemeliharaanController::class, 'destroy_detail_pemeliharaan'])->name('aset_pemeliharaan.destroy_detail_pemeliharaan');

    // LAPORAN
    Route::get('/laporan/aset-masuk', [LaporanController::class, 'laporan_masuk'])->name('laporan.aset_masuk');
    Route::get('/laporan/aset-mutasi', [LaporanController::class, 'laporan_mutasi'])->name('laporan.aset_mutasi');
    Route::get('/laporan/aset-dihapuskan', [LaporanController::class, 'laporan_dihapuskan'])->name('laporan.aset_dihapuskan');

    // pdf
    Route::get('/laporan/export_pdf_masuk', [PdfController::class, 'export_pdf_masuk']);
    Route::get('/laporan/export_pdf_mutasi', [PdfController::class, 'export_pdf_mutasi']);
    Route::get('/laporan/export_pdf_penghapusan', [PdfController::class, 'export_pdf_penghapusan']);

    // pdf
    Route::get('/laporan/export_detail_masuk', [PdfController::class, 'export_detail_masuk']);
    Route::get('/laporan/export_detail_mutasi', [PdfController::class, 'export_detail_mutasi']);
    Route::get('/laporan/export_detail_penghapusan', [PdfController::class, 'export_detail_penghapusan']);

    Route::get('/account', [RegisteredUserController::class, 'index_account_dashboard'])->name('account.index');
    Route::get('/account/create', [RegisteredUserController::class, 'create_account_dashboard'])->name('account.create');
    Route::post('/account/store', [RegisteredUserController::class, 'store']);
    Route::get('/account/{user}/edit', [RegisteredUserController::class, 'edit_account']);
    Route::put('/account/{id}', [RegisteredUserController::class, 'update_account']);
    Route::delete('/account/{id}', [RegisteredUserController::class, 'destroy_account']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // setting gudang
    Route::resource('/setting/gudang', GudangController::class);
});

require __DIR__ . '/auth.php';
