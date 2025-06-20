<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('foto_ktp');
            $table->string('lokasi_usaha');
            $table->string('alamat');
            $table->string('email');
            $table->string('nomor_hp');
            $table->string('status');
            $table->date('tanggal_penjualan');
            $table->text('keterangan')->nullable();
            $table->text('catatan_tambahan')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('lokasi')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('jenis_produk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
