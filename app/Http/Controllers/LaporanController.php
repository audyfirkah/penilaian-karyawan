<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Karyawan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class LaporanController extends Controller
{
    public function index()
{
    $laporans = Laporan::with('karyawan.user')->get();

    if(Auth::user()->role == 'kepala sekolah'){
        return view('kepala.laporan.index', compact('laporans'));
    }

    return view('admin.laporan.index', compact('laporans'));
}

 public function list()
    {
        $karyawans = User::where('role', 'karyawan')->with('karyawan', 'divisi')->paginate(5);

        if(Auth::user()->role == 'kepala sekolah'){
            return view('kepala.laporan.list', compact('karyawans'));
        }

        return view('admin.laporan.list', compact('karyawans'));
    }


    // Menampilkan form untuk membuat laporan baru
    public function create($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if(Auth::user()->role == 'kepala sekolah'){
            return view('kepala.laporan.create', compact('karyawan'));
        }

        return view('admin.laporan.create', compact('karyawan'));
    }

    // Menyimpan laporan baru ke database
    public function store(Request $request, $id)
{
    $request->validate([
        'periode' => 'required|in:bulanan,semester,tahunan',
        'jenis' => 'required|string|max:255',
    ]);

    Laporan::create([
        'id_karyawan' => $id,
        'periode' => $request->periode,
        'jenis' => $request->jenis,
    ]);
    if(Auth::user()->role == 'admin'){
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    return redirect()->route('kepala.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
}



    public function exportPdf($id)
{
    $laporan = Laporan::with('karyawan.user')->findOrFail($id);
    $periode = $laporan->periode;
    $createdAt = $laporan->created_at;

    // Awal dan akhir rentang berdasarkan periode
    switch ($periode) {
        case 'bulanan':
            $start = $createdAt->copy()->startOfMonth();
            $end = $createdAt->copy()->endOfMonth();
            break;
        case 'semester':
            $start = $createdAt->copy()->subMonths(5)->startOfMonth(); // 6 bulan total
            $end = $createdAt->copy()->endOfMonth();
            break;
        case 'tahunan':
            $start = $createdAt->copy()->subMonths(11)->startOfMonth(); // 12 bulan total
            $end = $createdAt->copy()->endOfMonth();
            break;
        default:
            $start = $createdAt->copy()->startOfMonth();
            $end = $createdAt->copy()->endOfMonth();
    }

    // Ambil semua data penilaian & detail penilaian sesuai periode dan karyawan
    $penilaians = \App\Models\Penilaian::with(['detailPenilaians', 'penilai'])
        ->where('id_karyawan', $laporan->id_karyawan)
        ->whereBetween('created_at', [$start, $end])
        ->get();

    // Data lain bisa ditambahkan jika perlu
    $jurnals = \App\Models\Jurnal::where('id_karyawan', $laporan->id_karyawan)
        ->whereBetween('tanggal', [$start, $end])
        ->get();

    if(Auth::user()->role == 'admin'){
    $pdf = Pdf::loadView('admin.laporan.export', [
        'laporan' => $laporan,
        'penilaians' => $penilaians,
        'jurnals' => $jurnals,
        'start' => $start,
        'end' => $end,
    ])->setPaper('a4', 'portrait');
    } else if(Auth::user()->role == 'kepala'){
        $pdf = Pdf::loadView('kepala.laporan.export', [
        'laporan' => $laporan,
        'penilaians' => $penilaians,
        'jurnals' => $jurnals,
        'start' => $start,
        'end' => $end,
    ])->setPaper('a4', 'portrait');
    }
    else {
        return;
    }

    return $pdf->download('laporan_'.$laporan->karyawan->user->nama .'_'. $laporan->periode .'_'. $laporan->created_at . '.pdf');
}

}
