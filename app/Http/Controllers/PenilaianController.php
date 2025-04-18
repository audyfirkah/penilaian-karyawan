<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\KategoriPenilaian;
use App\Models\DetailPenilaian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JurnalRevisi;



class PenilaianController extends Controller
{
    // Menampilkan daftar penilaian
    public function index()
    {

        $karyawan = Karyawan::with('user')->get();

        // Ambil semua id_jurnal yang sudah dinilai
        $jurnalSudahDinilai = Penilaian::pluck('id_jurnal')->toArray();

        // Ambil jurnal yang belum dinilai dan tidak dalam status revisi
        $jurnals = Jurnal::whereDoesntHave('penilaian')
        ->where('status', '!=', 'revisi')
        ->latest()
        ->paginate(5);

        if (Auth::user()->role === 'penilai') {
            return view('penilai.penilaian.index', compact('karyawan', 'jurnals'));
        }

        return view('kepala.penilaian.index', compact('karyawan', 'jurnals'));
    }


    // Halaman untuk membuat penilaian baru
    public function create($id)
    {
        $jurnal = Jurnal::with('karyawan.user')->findOrFail($id);
        $kategoris = KategoriPenilaian::all();

        if(Auth::user()->role == 'penilai') {
            return view('penilai.penilaian.create', compact('jurnal', 'kategoris'));
        }

        return view('penilai.penilaian.create', compact('jurnal', 'kategoris'));
    }

    // Menyimpan penilaian baru
   public function store(Request $request, $id)
{
    // dd($id);

    $request->validate([
        // 'id_jurnal' => 'required|exists:jurnals,id_jurnal',
        'id_karyawan' => 'required|exists:karyawans,id_karyawan',
        'catatan' => 'nullable|string|max:255',
        'kategori_penilaian' => 'required|array',
        'kategori_penilaian.*' => 'required|numeric|min:0|max:100',
    ]);

    // Buat penilaian utama
    $penilaian = Penilaian::create([
        'id_penilai' => auth()->user()->id_user,
        'id_jurnal' => $id,
        'id_karyawan' => $request->id_karyawan,
        'tanggal_penilaian' => Carbon::now()->format('Y-m-d'),
        'total_skor' => 0, // dihitung nanti
        'keterangan' => null,
        'catatan' => $request->catatan,
    ]);

    $total = 0;
    $details = [];

    foreach ($request->kategori_penilaian as $id_kategori => $skor) {
        $details[] = new DetailPenilaian([
            'id_penilaian' => $penilaian->id_penilaian,
            'id_kategori' => $id_kategori,
            'skor' => $skor
        ]);
        $total += $skor;
    }

    $penilaian->detailPenilaians()->saveMany($details);

    // Hitung rata-rata skor
    $rata2 = count($details) > 0 ? round($total / count($details), 2) : 0;
    $penilaian->total_skor = $rata2;

    // Keterangan otomatis dari skor
    switch (true) {
        case ($rata2 >= 9):
            $penilaian->keterangan = 'Sangat Baik';
            break;
        case ($rata2 >= 7.5):
            $penilaian->keterangan = 'Baik';
            break;
        case ($rata2 >= 6):
            $penilaian->keterangan = 'Cukup';
            break;
        case ($rata2 >= 4):
            $penilaian->keterangan = 'Kurang';
            break;
        default:
            $penilaian->keterangan = 'Sangat Kurang';
    }

    $penilaian->save();

    // Arahkan ke role yang sesuai
    if(Auth::user()->role === 'penilai'){
        return redirect()->route('penilai.penilaian.index')->with('success', 'Penilaian berhasil disimpan.');
    }

    return redirect()->route('kepala.penilaian.index')->with('success', 'Penilaian berhasil!');
}

public function revisi(Request $request, $id)
{

    try {
            // Cari jurnal berdasarkan ID
            $jurnal = Jurnal::findOrFail($id);

            // Validasi input dari form
            $validated = $request->validate([
                'catatan' => 'required|string',
                'lampiran' => 'nullable|file|mimes:pdf,jpg,png,docx|max:2048',
            ]);

            $path = null;

            // Jika ada lampiran baru dikirim
            if ($request->hasFile('lampiran')) {
                $path = $request->file('lampiran')->store('revisi_lampiran', 'public');
            }

            // Jika tidak ada lampiran baru, tapi jurnal punya lampiran lama
            elseif ($jurnal->lampiran) {
                $originalPath = 'public/' . $jurnal->lampiran;
                $ext = pathinfo($jurnal->lampiran, PATHINFO_EXTENSION);
                $baseName = pathinfo($jurnal->lampiran, PATHINFO_FILENAME);

                $newFileName = $baseName . '_revisi_' . Carbon::now()->format('Ymd_His') . '.' . $ext;
                $newPath = 'revisi_lampiran/' . $newFileName;

                if (Storage::exists($originalPath)) {
                    Storage::copy($originalPath, 'public/' . $newPath);
                    $path = $newPath;
                }
            }

            // Buat entri revisi
            JurnalRevisi::create([
                'id_jurnal' => $jurnal->id_jurnal,
                'id_user' => auth()->id(),
                'catatan' => $validated['catatan'],
                'lampiran' => $path,
                'status_sebelumnya' => $jurnal->status,
                'status_baru' => 'revisi',
            ]);

            // Update status jurnal
            $jurnal->update([
                'status' => 'revisi',
            ]);

            // Jika request AJAX, kirim response JSON
            if ($request->ajax()) {
                return response()->json(['message' => 'Revisi berhasil dikirim.']);
            }

            // Jika tidak, redirect kembali dengan pesan sukses
            return back()->with('success', 'Revisi berhasil dikirim.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error
return response()->json(['error' => 'Terjadi kesalahan pada server: ' . $e->getMessage()], 500);        }

}


}
