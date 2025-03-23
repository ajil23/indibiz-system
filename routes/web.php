<?php

use App\Http\Controllers\Admin\LokasiController;
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
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

        // Kategori lokasi
        Route::group(['prefix' => 'kategori-lokasi'], function () {
            Route::get('/view', [LokasiController::class, 'index'])->name('lokasi.index');
            Route::post('/store', [LokasiController::class, 'store'])->name('lokasi.store');
            Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
            Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
        });
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('pimpinan', PimpinanController::class);
    });
    Route::group(['middleware' => ['loginCheck:admin']], function () {
        Route::resource('sales', SalesController::class);
    });
});
