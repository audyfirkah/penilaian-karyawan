<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\KategoriPenilaian;
use App\Models\DetailPenilaian;
use Illuminate\Support\Facades\DB;




class PenilaianController extends Controller
{
    // Menampilkan daftar penilaian
    public function index()
    {

        $penilaians = Penilaian::with('karyawan', 'penilai', 'detailPenilaians.kategori')
            ->orderBy('created_at', 'desc')
            ->get();
        if(Auth::user()->role == 'penilai') {
            return view('penilai.penilaian.index', compact('penilaians'));
        }

        return view('kepala.penilaian.index', compact('penilaians'));
    }



    // Menampilkan daftar karyawan untuk penilaian
    public function list()
    {
        $karyawans = User::where('role', 'karyawan')->with('karyawan', 'divisi')->paginate(5);

        if(Auth::user()->role == 'penilai') {
            return view('penilai.penilaian.list', compact('karyawans'));
        }

        return view('kepala.penilaian.list', compact('karyawans'));
    }

    // Halaman untuk membuat penilaian baru
    public function create($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        $kategoris = KategoriPenilaian::all();

        if(Auth::user()->role == 'penilai') {
            return view('penilai.penilaian.create', compact('karyawan', 'kategoris'));
        }

        return view('penilai.penilaian.create', compact('karyawan', 'kategoris'));
    }

    // Menyimpan penilaian baru
   public function store(Request $request, $id)
{
    $request->validate([
        'tanggal_penilaian' => 'required|date',
        'periode' => 'required|in:bulanan,semester,tahunan',
        'catatan' => 'nullable|string|max:255',
        'kategori_penilaian' => 'required|array',
        'kategori_penilaian.*' => 'required|numeric|min:0|max:10',
    ]);

    // dd($request->kategori_penilaian);


    $penilaian = Penilaian::create([
        'id_karyawan' => $id,
        'id_penilai' => auth()->user()->id_user,
        'tanggal_penilaian' => $request->tanggal_penilaian,
        'periode' => $request->periode,
        'total_skor' => 0,
        'keterangan' => 'Tersimpan',
        'catatan' => $request->catatan,
    ]);

    $total = 0;
    $details = [];


    foreach ($request->kategori_penilaian as $id_kategori => $skor) {
        if (!$id_kategori || !$skor) {
            dd("Data kosong!", $id_kategori, $skor);
        }

        $details[] = new DetailPenilaian([
            'id_penilaian' => $penilaian->id_penilaian,
            'id_kategori' => $id_kategori,
            'skor' => $skor
        ]);
        $total += $skor;
    }


    // Simpan sekaligus lewat relasi
    $penilaian->detailPenilaians()->saveMany($details);

    $penilaian->total_skor = count($details) > 0 ? round($total / count($details), 2) : 0;

    switch (true) {
    case ($skor >= 9):
        $penilaian->keterangan = 'Sangat Baik';
        break;
    case ($skor >= 7.5):
        $penilaian->keterangan = 'Baik';
        break;
    case ($skor >= 6):
        $penilaian->keterangan = 'Cukup';
        break;
    case ($skor >= 4):
        $penilaian->keterangan = 'Kurang';
        break;
    default:
        $penilaian->keterangan = 'Sangat Kurang';
}

    $penilaian->save();

    if(Auth::user()->role === 'penilai'){
        return redirect()->route('penilai.penilaian.index')->with('success', 'Penilaian berhasil disimpan.');
    }

    return redirect()->route('kepala.penilaian.index')->with('success', 'Penilaian berhasil!');
}


}
