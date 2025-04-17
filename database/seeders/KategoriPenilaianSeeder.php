<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriPenilaian;

class KategoriPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriPenilaian::insert([
            ['nama_kategori' => 'Tanggung Jawab', 'deskripsi' => 'Tanggung jawab dalam pekerjaan'],
            ['nama_kategori' => 'Loyalitas', 'deskripsi' => 'Tingkat disiplin kerja'],
            ['nama_kategori' => 'Kerjasama', 'deskripsi' => 'Kemampuan bekerja sama'],
            ['nama_kategori' => 'Inovasi', 'deskripsi' => 'Kemampuan menciptakan inovasi'],
        ]);
    }
}
