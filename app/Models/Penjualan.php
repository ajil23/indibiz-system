<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_pelanggan', 'alamat', 'lokasi_usaha', 'email', 'nomor_hp', 'koordinat', 'keterangan', 'kode_partner', 'status', 'keterangan','sales_id', 'kategori_id', 'produk_id'];

    public function user(){
        return $this->belongsTo(User::class,'sales_id','id');
    }

    public function kategori_lokasi(){
        return $this->belongsTo(Lokasi::class,'kategori_id','id');
    }

    public function jenis_produk(){
        return $this->belongsTo(JenisProduk::class, 'produk_id','id');
    }
}
