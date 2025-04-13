<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPenilaian extends Model
{
    protected $table = 'kategori_penilaians';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'bobot',
        'deskripsi',
    ];
}
