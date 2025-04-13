<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Karyawan;


class LaporanController extends Controller
{
    public function index()
{
    $laporans = Laporan::with('karyawan.user')->get();
    return view('admin.laporan.index', compact('laporans'));
}


    // Menampilkan form untuk membuat laporan baru
    public function create()
    {
        $karyawans = Karyawan::all();
        return view('admin.laporan.create', compact('karyawans'));
    }

    // Menyimpan laporan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id_karyawan',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        Laporan::create([
            'karyawan_id' => $request->karyawan_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    // Menampilkan detail laporan
    public function show($id)
    {
        $laporan = Laporan::with('karyawan.user')->findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    // Menghapus laporan dari database
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
