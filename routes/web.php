<?php

use App\Http\Controllers\Admin\BahanBakarController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\TnkbController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Users\PimpinanController;
use App\Http\Controllers\Users\SalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        // Kategori lokasi
        Route::get('/view/kategori-lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::post('/store/kategori-lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::put('/lokasi/{id}/kategori-lokasi', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{id}/kategori-lokasi', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        // Jenis BBM
        Route::get('/view/jenis-bbm', [BahanBakarController::class, 'index'])->name('bbm.index');
        Route::post('/store/jenis-bbm', [BahanBakarController::class, 'store'])->name('bbm.store');
        Route::put('/bbm/{id}/jenis-bbm', [BahanBakarController::class, 'update'])->name('bbm.update');
        Route::delete('/bbm/{id}/jenis-bbm', [BahanBakarController::class, 'destroy'])->name('bbm.destroy');

        // TNKB
        Route::get('/view/tnkb', [TnkbController::class, 'index'])->name('tnkb.index');
        Route::post('/store/tnkb', [TnkbController::class, 'store'])->name('tnkb.store');
        Route::put('/tnkb/{id}/tnkb', [TnkbController::class, 'update'])->name('tnkb.update');
        Route::delete('/tnkb/{id}/tnkb', [TnkbController::class, 'destroy'])->name('tnkb.destroy');
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('pimpinan', PimpinanController::class);
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('sales', SalesController::class);
    });
});
