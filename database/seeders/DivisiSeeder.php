<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::insert([
            ['nama_divisi' => 'IT', 'deskripsi' => 'Divisi Teknologi Informasi'],
            ['nama_divisi' => 'HRD', 'deskripsi' => 'Divisi Sumber Daya Manusia'],
        ]);
    }
}
