<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penawaran';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_lokasi', 'alamat', 'tanggal_kunjungan', 'pic', 'nomor_hp', 'bukti_kunjungan', 'keterangan', 'feedback', 'sales_id', 'kategori_id'];

    public function user(){
        return $this->belongsTo(User::class,'sales_id','id');
    }

    public function kategori_lokasi(){
        return $this->belongsTo(Lokasi::class,'kategori_id','id');
    }
}
