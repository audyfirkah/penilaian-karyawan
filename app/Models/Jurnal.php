<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnals';
    protected $primaryKey = 'id_jurnal';
    protected $guarded = [
        'id_karyawan',
        'tanggal',
        'aktivitas',
        'lampiran',
    ];

    protected $casts = [
    'tanggal' => 'date',
];


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penilaian() {
        return $this->hasMany(Penilaian::class, 'id_jurnal', 'id_jurnal');
    }
}
