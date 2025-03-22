<?php

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

Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['loginCheck:admin']], function(){
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });
    Route::group(['middleware' => ['loginCheck:admin']], function(){
        Route::resource('pimpinan', PimpinanController::class);
    });
    Route::group(['middleware' => ['loginCheck:admin']], function(){
        Route::resource('sales', SalesController::class);
    });
});