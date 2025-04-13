<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailPenilaian;

class DetailPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailPenilaian::insert([
            ['id_penilaian' => 1, 'id_kategori' => 1, 'skor' => 85.5],
            ['id_penilaian' => 1, 'id_kategori' => 2, 'skor' => 90.0],
        ]);
    }
}
