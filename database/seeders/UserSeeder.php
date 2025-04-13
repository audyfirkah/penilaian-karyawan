<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'nama' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Penilai Satu',
                'email' => 'penilai@example.com',
                'password' => Hash::make('password'),
                'role' => 'penilai',
            ],
            [
                'nama' => 'Karyawan Satu',
                'email' => 'karyawan@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ],
            [
                'nama' => 'Kepala Sekolah',
                'email' => 'kepsek@example.com',
                'password' => Hash::make('password'),
                'role' => 'kepala sekolah',
            ]
        ]);
    }
}
