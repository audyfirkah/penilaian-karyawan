<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Divisi;
use App\Models\KategoriPenilaian;

class PenilaianController extends Controller
{
    public function index() {

        // dd('masuk index penilaian');
        // Logic to display the list of penilaian

        $penilaians = Penilaian::with('karyawan', 'kategori', 'penilai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penilai.penilaian.index', compact('penilaians'));
    }

    public function list()
    {
        $karyawans = User::where('role', 'karyawan')->with('karyawan', 'divisi' )->paginate(5);
        return view('penilai.penilaian.list', compact('karyawans'));
    }

    public function create($id)
    {
        // dd($id);
        // Logic to show the form for creating a new penilaian
        $karyawan = Karyawan::findOrFail($id);
        $penilai = auth()->user();
        $kategoris = KategoriPenilaian::all();

        return view('penilai.penilaian.create', compact('karyawan', 'penilai', 'kategoris'));
    }
}
