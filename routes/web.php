<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AsetMasukController;
use App\Http\Controllers\AsetMutasiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DetailAsetController;
use App\Http\Controllers\DetailAsetMutasiController;
use App\Http\Controllers\KategoriController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // master data
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/ruangan', RuanganController::class);
    Route::resource('/aset', AsetController::class);

    // transaksi
    Route::resource('/aset_masuk', AsetMasukController::class);
    Route::resource('/detail_aset', DetailAsetController::class);
    Route::resource('/aset_mutasi', AsetMutasiController::class);
    Route::get('/get_detail_aset/aset_mutasi/{id}', [AsetMutasiController::class, 'get_detail_aset']);

    Route::resource('/detail_aset_mutasi', DetailAsetMutasiController::class);


    Route::get('/account', [RegisteredUserController::class, 'index_account_dashboard'])->name('account.index');
    Route::get('/account/create', [RegisteredUserController::class, 'create_account_dashboard'])->name('account.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
