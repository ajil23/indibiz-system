<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianBbm extends Model
{
    protected $table = 'pembelian_bbm';
    protected $primaryKey = 'id';
    protected $fillable = ['pengemudi', 'tanggal_pembelian', 'lokasi_tujuan', 'harga', 'lokasi_pembelian', 'foto_nota', 'keterangan',  'tnkb_id', 'bbm_id'];

    public function tnkb(){
        return $this->belongsTo(Tnkb::class,'tnkb_id','id');
    }

    public function bbm(){
        return $this->belongsTo(BahanBakar::class,'bbm_id','id');
    }
}
