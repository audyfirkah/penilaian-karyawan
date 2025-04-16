<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;

class DetailPenilaianController extends Controller
{
    public function detail($id)
    {
        // Gunakan findOrFail untuk memastikan hanya satu data yang diambil dan akan throw error jika tidak ada
        $penilaian = Penilaian::with([
            'karyawan.user', // Menyertakan relasi karyawan dan user terkait
            'penilai', // Menyertakan data penilai
            'detailPenilaians.kategori' // Menyertakan detail penilaian dan kategori penilaian
        ])
        ->findOrFail($id); // Mengambil data berdasarkan ID, dan otomatis error jika data tidak ada

        return view('penilai.penilaian.detail', compact('penilaian'));
    }
}
