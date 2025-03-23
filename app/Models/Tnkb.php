<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tnkb extends Model
{
    protected $table = 'tnkb';
    protected $primaryKey = 'id';
    protected $fillable = ['nomor_polisi','kendaraan','jenis'];
}
