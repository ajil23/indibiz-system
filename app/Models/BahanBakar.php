<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    protected $table = 'bbm';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_bbm','deskripsi','harga'];
}
