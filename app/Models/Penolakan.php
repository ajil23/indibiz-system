<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penolakan extends Model
{
    protected $table = 'penolakan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_lokasi', 'alamat', 'tanggal_kunjungan', 'catatan_penolakan', 'sales_id',  'produk_id'];

    public function user(){
        return $this->belongsTo(User::class,'sales_id','id');
    }

    public function jenis_produk(){
        return $this->belongsTo(JenisProduk::class, 'produk_id','id');
    }
}
