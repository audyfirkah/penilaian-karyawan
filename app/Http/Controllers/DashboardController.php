<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\KategoriPenilaian;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardController extends Controller
{

    public function admin()
    {
        // Filter berdasarkan bulan
        $bulan = $request->bulan ?? now()->format('Y-m');

        // Ambil data jurnal sesuai bulan
        $jurnals = Jurnal::with(['karyawan.user', 'karyawan.divisi'])
            ->where('status', 'pending')
            ->paginate(5);

        // Statistik global
        $jumlahLaporan = laporan::count();
        $jumlahPenilaian = \App\Models\Penilaian::count();
        $jurnalBelumDisetujui = Jurnal::where('status', '!=', 'approved')->count();

        // Grup per divisi
        $jurnalByDivisi = Jurnal::with('karyawan.divisi')
            ->selectRaw("id_karyawan, status")
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->get()
            ->groupBy(function ($item) {
                return $item->karyawan->divisi->nama_divisi ?? 'Tidak Diketahui';
            })
            ->map(function ($items, $divisi) {
                return [
                    'divisi' => $divisi,
                    'approved' => $items->where('status', 'approved')->count(),
                    'pending' => $items->where('status', 'pending')->count(),
                    'revisi' => $items->where('status', 'revisi')->count(),
                ];
            })
            ->values();

        return view('admin.dashboard', compact(
            'jumlahLaporan',
            'jumlahPenilaian',
            'jurnalBelumDisetujui',
            'jurnalByDivisi',
            'jurnals'
        ));
    }

    public function exportJurnalPDF(Request $request)
    {
        $bulan = $request->bulan;
        $jurnals = Jurnal::whereMonth('tanggal', Carbon::parse($bulan)->month)
                        ->whereYear('tanggal', Carbon::parse($bulan)->year)
                        ->where('status', '!=', 'approved')
                        ->with('karyawan.user', 'karyawan.divisi')
                        ->get();

        $pdf = Pdf::loadView('admin.export.jurnal_pdf', compact('jurnals', 'bulan'));
        return $pdf->download("Jurnal-Bulan-$bulan.pdf");
    }

    public function karyawan()
    {
        $user = auth()->user();
        $idKaryawan = $user->karyawan->id_karyawan;

        // Jumlah jurnal per status
        $jumlahJurnal = Jurnal::where('id_karyawan', $idKaryawan)->count();
        $jurnalApproved = Jurnal::where('id_karyawan', $idKaryawan)->where('status', 'approved')->count();
        $jurnalPending = Jurnal::where('id_karyawan', $idKaryawan)->where('status', 'pending')->count();
        $jurnalRevisi = Jurnal::where('id_karyawan', $idKaryawan)->where('status', 'revisi')->count();

        $jurnals = Jurnal::where('id_karyawan', $idKaryawan)->orderBy('tanggal', 'desc')->paginate(5);

        return view('karyawan.dashboard', compact(
            'jumlahJurnal',
            'jurnalApproved',
            'jurnalPending',
            'jurnalRevisi',
            'jurnals'
        ));
    }

    public function penilai(){
         $jumlahPenilaian = Penilaian::count();
    $jumlahKategori = KategoriPenilaian::count();

    $penilaians = Penilaian::with('karyawan.user', 'penilai', 'detailPenilaians.kategori')
        ->latest()->paginate(5);

    // Karyawan yang belum dinilai bulan ini
    $bulanIni = now()->format('Y-m');

    $sudahDinilai = Penilaian::pluck('id_jurnal')->toArray();
    $belumDinilai = Jurnal::whereNotIn('id_jurnal', $sudahDinilai)
        ->get();

    return view('penilai.dashboard', compact(
        'jumlahPenilaian',
        'jumlahKategori',
        'penilaians',
        'belumDinilai'
    ));
    }

    public function kepala()
    {
         $jumlahPenilaian = Penilaian::count();
    $jumlahKategori = KategoriPenilaian::count();

    $penilaians = Penilaian::with('karyawan.user', 'penilai', 'detailPenilaians.kategori')
        ->latest()->paginate(5);

    // Karyawan yang belum dinilai bulan ini
    $bulanIni = now()->format('Y-m');

    $sudahDinilai = Penilaian::pluck('id_jurnal')->toArray();
    $belumDinilai = Jurnal::whereNotIn('id_jurnal', $sudahDinilai)
        ->get();

    return view('kepala.dashboard', compact(
        'jumlahPenilaian',
        'jumlahKategori',
        'penilaians',
        'belumDinilai'
    ));
    }
}
