<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;
use App\Models\KategoriPenilaian;
use App\Models\User;

class Penilaian extends Model
{
    protected $primaryKey = 'id_penilaian';
public $incrementing = true;
protected $keyType = 'int';

protected $fillable = [
    'id_karyawan',
    'id_penilai',
    'id_jurnal',
    'tanggal_penilaian',
    'total_skor',
    'keterangan',
    'catatan',
];

protected $casts = [
    'tanggal_penilaian' => 'date',
];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'id_penilai');
    }

    public function detailPenilaians()
    {
        return $this->hasMany(DetailPenilaian::class, 'id_penilaian', 'id_penilaian');
    }

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }
}
