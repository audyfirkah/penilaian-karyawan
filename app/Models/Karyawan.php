<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{

    protected $table = 'karyawans';
     protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_user',
        'nip',
        'no_hp',
        'alamat',
        'tgl_masuk',
        'foto_profil',
        'id_divisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function jurnal(){
        return $this->hasMany(Jurnal::class, 'id_karyawan');
    }
    public function jurnals(){
        return $this->hasMany(Jurnal::class, 'id_karyawan');
    }
}
