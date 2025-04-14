<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;
use App\Models\KategoriPenilaian;
use App\Models\User;

class Penilaian extends Model
{
    protected $table = 'penilaians';
    protected $primarykey = 'id_penilaian';
    protected $fillable = [
        'id_karyawan',
        'id_penilai',
        'tanggal_penilaian',
        'periode',
        'total_skor',
        'status',
        'catatan',
        'created_at',
        'updated_at'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'id_penilai');
    }
}
