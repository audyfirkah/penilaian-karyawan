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

    public function store(Request $request, $id)
    {
        dd($request->all());
        // Logic to store a new penilaian
        $validatedData = $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'id_penilai' => 'required|exists:users,id_user',
            'tanggal_penilaian' => 'required|date',
            'periode' => 'required|string|max:255',
            'total_skor' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
        ]);

        Penilaian::create($validatedData);

        return redirect()->route('penilai.penilaian.index')->with('success', 'Penilaian created successfully.');
    }
}
