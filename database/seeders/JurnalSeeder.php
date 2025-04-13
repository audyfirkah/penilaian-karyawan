<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurnal;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurnal::create([
            'id_karyawan' => 1,
            'tanggal' => now(),
            'aktivitas' => 'Mengerjakan laporan bulanan',
            'lampiran' => null,
        ]);
    }
}
