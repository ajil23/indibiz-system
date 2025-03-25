<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaporanKendaraan extends Model
{
    protected $table = 'pelaporan_kendaraan';
    protected $primaryKey = 'id';
    protected $fillable = ['pengemudi', 'tanggal_penggunaan', 'lokasi_tujuan', 'waktu_mulai', 'waktu_selesai', 'jumlah_odo', 'keterangan', 'foto_odo', 'tnkb_id'];

    public function tnkb(){
        return $this->belongsTo(Tnkb::class,'tnkb_id','id');
    }
}
