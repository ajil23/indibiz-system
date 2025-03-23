<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_sektor','sub_sektor'];
}
