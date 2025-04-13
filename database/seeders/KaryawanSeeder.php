<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::insert([
            [
                'id_user' => 3, // id user dengan role karyawan
                'nip' => '123456789',
                'no_hp' => '08123456789',
                'alamat' => 'Jl. Contoh No.1',
                'tgl_masuk' => '2022-01-01',
                'foto_profil' => null,
                'id_divisi' => 1
            ]
        ]);
    }
}
