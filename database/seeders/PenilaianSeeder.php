<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penilaian;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penilaian::create([
            'id_karyawan' => 1,
            'id_penilai' => 2, // id user dengan role penilai
            'tanggal_penilaian' => now(),
            'periode' => 'bulanan',
            'total_skor' => 8.5,
            'keterangan' => 'Baik',
            'catatan' => 'Pertahankan prestasi yang baik.',
        ]);
    }
}
