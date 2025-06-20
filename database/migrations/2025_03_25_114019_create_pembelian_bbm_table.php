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
        Schema::create('pembelian_bbm', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pembelian');
            $table->string('lokasi_tujuan');
            $table->string('harga');
            $table->string('total_pembelian');
            $table->string('lokasi_pembelian');
            $table->string('foto_nota');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('bbm_id');
            $table->unsignedBigInteger('tnkb_id');
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bbm_id')->references('id')->on('bbm')->onDelete('cascade');
            $table->foreign('tnkb_id')->references('id')->on('tnkb')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bbm');
    }
};
