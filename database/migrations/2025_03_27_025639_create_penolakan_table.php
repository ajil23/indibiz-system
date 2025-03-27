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
        Schema::create('penolakan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->string('alamat');
            $table->string('tanggal_kunjungan');
            $table->text('catatan_penolakan');
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('produk_id');
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
        Schema::dropIfExists('penolakan');
    }
};
