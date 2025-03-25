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
            $table->string('lokasi_usaha');
            $table->string('alamat');
            $table->string('email');
            $table->string('koordinat');
            $table->string('nomor_hp');
            $table->string('kode_partner');
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('produk_id');
            $table->foreign('kategori_id')->references('id')->on('lokasi')->onDelete('cascade');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
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
