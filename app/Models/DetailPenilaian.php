<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    protected $table = 'detail_penilaians';
    protected $primarykey = 'id_detail_penilaian';
    protected $fillable = [
        'id_penilaian',
        'id_kategori',
        'skor'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'id_penilaian');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }

}
