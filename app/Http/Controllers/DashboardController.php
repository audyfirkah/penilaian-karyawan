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

class DashboardController extends Controller
{

    public function admin()
    {
        $jumlahLaporan = Laporan::count();
        $jumlahPenilaian = Penilaian::count();

        $users = User::with('karyawan', 'divisi')->paginate(5);
        $laporans = Laporan::with('karyawan.user')->paginate(5);

        return view('admin.dashboard', compact(
            'jumlahLaporan',
            'jumlahPenilaian',
            'users',
            'laporans'
        ));
    }

    public function karyawan()
    {
        $jumlahJurnal = Jurnal::count();
        $jurnals = Jurnal::with('karyawan.user')->paginate(5);

        return view('karyawan.dashboard', compact(
            'jumlahJurnal',
            'jurnals'
        ));
    }

    public function penilai(){
        $jumlahPenilaian = Penilaian::count();
        $jumlahKategori = KategoriPenilaian::count();
        $penilaians = Penilaian::with('karyawan', 'penilai', 'detailPenilaians.kategori')->paginate(5);

        return view('penilai.dashboard', compact(
            'jumlahPenilaian',
            'jumlahKategori',
            'penilaians'
        ));
    }

    public function kepala()
    {
        $jumlahLaporan = Laporan::count();
        $jumlahPenilaian = Penilaian::count();

        $karyawans = User::where('role', 'karyawan')->with('karyawan', 'divisi')->paginate(5);

        return view('kepala.dashboard', compact(
            'jumlahLaporan',
            'jumlahPenilaian',
            'karyawans'
        ));
    }
}
