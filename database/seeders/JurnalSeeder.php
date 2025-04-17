<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurnal;
use Carbon\Carbon;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 1; $i <= 10; $i++) {
            // Tentukan status yang berbeda
            $status = ['pending', 'approved', 'revisi'];

            // Tentukan tanggal yang berbeda setiap jurnal
            $tanggal = Carbon::now()->subDays(rand(0, 30));

            // Pilih status secara acak
            $statusPilihan = $status[array_rand($status)];

            Jurnal::create([
                'id_karyawan' => 1,
                'tanggal' => $tanggal,
                'status' => $statusPilihan,
                'approved_by' => 2, // ID yang menyetujui, misalnya admin
                'aktivitas' => 'Mengerjakan laporan bulanan',
                'lampiran' => null,
            ]);

        }

    }
}
