<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    protected $table = 'jenis_produk';
    protected $primaryKey = 'id';
    protected $fillable = ['nama','deskripsi'];
}
