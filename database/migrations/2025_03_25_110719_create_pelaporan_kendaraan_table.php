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
        Schema::create('pelaporan_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('pengemudi');
            $table->string('tanggal_penggunaan');
            $table->string('lokasi_tujuan');
            $table->string('waktu_mulai');
            $table->string('waktu_selesai');
            $table->string('jumlah_odo');
            $table->string('foto_odo');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('tnkb_id');
            $table->foreign('tnkb_id')->references('id')->on('tnkb')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporan_kendaraan');
    }
};
