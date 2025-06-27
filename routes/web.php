<?php

use App\Http\Controllers\Admin\BahanBakarController;
use App\Http\Controllers\Admin\JenisProdukController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PelaporanKendaraanController;
use App\Http\Controllers\Admin\PembelianBBMController;
use App\Http\Controllers\Admin\PenawaranController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Admin\PenolakanController as AdminPenolakanController;
use App\Http\Controllers\Admin\TnkbController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Sales\PelaporanKendaraanController as SalesPelaporanKendaraanController;
use App\Http\Controllers\Sales\PembelianBBMController as SalesPembelianBBMController;
use App\Http\Controllers\Sales\PenawaranController as SalesPenawaranController;
use App\Http\Controllers\Sales\PenjualanController as SalesPenjualanController;
use App\Http\Controllers\Sales\PenolakanController;
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
    Route::group(['middleware' => ['loginCheck:admin,pimpinan']], function () {
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

        // Jenis Produk
        Route::get('/view/jenis-produk', [JenisProdukController::class, 'index'])->name('jenis-produk.index');
        Route::post('/store/jenis-produk', [JenisProdukController::class, 'store'])->name('jenis-produk.store');
        Route::put('/jenis-produk/{id}/jenis-produk', [JenisProdukController::class, 'update'])->name('jenis-produk.update');
        Route::delete('/jenis-produk/{id}/jenis-produk', [JenisProdukController::class, 'destroy'])->name('jenis-produk.destroy');

        // Penawaran
        Route::get('/view/penawaran', [PenawaranController::class, 'index'])->name('penawaran.index');
        Route::post('/store/penawaran', [PenawaranController::class, 'store'])->name('penawaran.store');
        Route::put('/penawaran/{id}/penawaran', [PenawaranController::class, 'update'])->name('penawaran.update');
        Route::delete('/penawaran/{id}/penawaran', [PenawaranController::class, 'destroy'])->name('penawaran.destroy');
        Route::post('/export/penawaran', [PenawaranController::class, 'exportData'])->name('penawaran.exportData');

        // Penolakan
        Route::get('/view/penolakan', [AdminPenolakanController::class, 'index'])->name('penolakan.index');
        Route::post('/store/penolakan', [AdminPenolakanController::class, 'store'])->name('penolakan.store');
        Route::put('/penolakan/{id}/penolakan', [AdminPenolakanController::class, 'update'])->name('penolakan.update');
        Route::delete('/penolakan/{id}/penolakan', [AdminPenolakanController::class, 'destroy'])->name('penolakan.destroy');
        Route::post('/export/penolakan', [AdminPenolakanController::class, 'exportData'])->name('penolakan.exportData');

        // Penjualan
        Route::get('/view/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::post('/store/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::put('/penjualan/{id}/penjualan', [PenjualanController::class, 'update'])->name('penjualan.update');
        Route::delete('/penjualan/{id}/penjualan', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
        Route::post('/export/penjualan', [PenjualanController::class, 'exportData'])->name('penjualan.exportData');

        // Pelaporan Kendaraan
        Route::get('/view/pelaporan_kendaraan', [PelaporanKendaraanController::class, 'index'])->name('pelaporan.index');
        Route::post('/export/pelaporan_kendaraan', [PelaporanKendaraanController::class, 'exportData'])->name('pelaporan.exportData');

        // Pembelian BBM
        Route::get('/view/pembelian_bbm', [PembelianBBMController::class, 'index'])->name('pembelian.index');
        Route::post('/store/pembelian_bbm', [PembelianBBMController::class, 'store'])->name('pembelian.store');
        Route::post('/export/pembelian_bbm', [PembelianBBMController::class, 'exportData'])->name('pembelian.exportData');

        // User
        Route::get('/view/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/store/user', [UserController::class, 'store'])->name('user.store');
        Route::put('/user/{id}/user', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}/user', [UserController::class, 'destroy'])->name('user.destroy');
    });
    
    Route::group(['middleware' => ['loginCheck:sales']], function () {
        Route::resource('sales', SalesController::class);

        // Penawaran
        Route::get('/view/sales_penawaran', [SalesPenawaranController::class, 'index'])->name('sales_penawaran.index');
        Route::post('/store/sales_penawaran', [SalesPenawaranController::class, 'store'])->name('sales_penawaran.store');
        Route::put('/sales_penawaran/{id}/sales_penawaran', [SalesPenawaranController::class, 'update'])->name('sales_penawaran.update');

        // Penolakan
        Route::get('/view/sales_penolakan', [PenolakanController::class, 'index'])->name('sales_penolakan.index');
        Route::post('/store/sales_penolakan', [PenolakanController::class, 'store'])->name('sales_penolakan.store');
        Route::put('/sales_penolakan/{id}/sales_penolakan', [PenolakanController::class, 'update'])->name('sales_penolakan.update');
        
        // Penjualan
        Route::get('/view/sales_penjualan', [SalesPenjualanController::class, 'index'])->name('sales_penjualan.index');
        Route::post('/store/sales_penjualan', [SalesPenjualanController::class, 'store'])->name('sales_penjualan.store');
        Route::put('/sales_penjualan/{id}/sales_penjualan', [SalesPenjualanController::class, 'update'])->name('sales_penjualan.update');
        
        // Pembelian BBM
        Route::get('/view/sales_pembelian_bbm', [SalesPembelianBBMController::class, 'index'])->name('sales_pembelian.index');
        Route::post('/store/sales_pembelian_bbm', [SalesPembelianBBMController::class, 'store'])->name('sales_pembelian.store');
        Route::put('/sales_pembelian/{id}/sales_pembelian', [SalesPembelianBBMController::class, 'update'])->name('sales_pembelian.update');
        
        // Pelaporan Kendaraan
        Route::get('/view/sales_pelaporan_kendaraan', [SalesPelaporanKendaraanController::class, 'index'])->name('sales_pelaporan.index');
        Route::post('/store/sales_pelaporan_kendaraan', [SalesPelaporanKendaraanController::class, 'store'])->name('sales_pelaporan.store');
        Route::put('/sales_pelaporan_kendaraan/{id}/sales_pelaporan_kendaraan', [SalesPelaporanKendaraanController::class, 'update'])->name('sales_pelaporan.update');
        
    });
});
