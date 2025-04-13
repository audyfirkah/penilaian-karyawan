<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{

    protected $table = 'divisis';
    protected $primaryKey = 'id_divisi'; // Jika menggunakan id_divisi sebagai primary key
    protected $fillable = ['nama_divisi', 'deskripsi'];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'id_divisi');
    }

}
