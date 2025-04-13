<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    // Menampilkan daftar divisi
    public function index()
    {
        $divisis = Divisi::all();
        return view('admin.divisi.index', compact('divisis'));
    }

    // Menampilkan form untuk membuat divisi baru
    public function create()
    {
        return view('admin.divisi.create');
    }

    // Menyimpan divisi baru ke dalam database
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        // Simpan data divisi
        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    // Menampilkan form untuk edit divisi
    public function edit($id)
{
    // Mengubah 'id' menjadi 'id_divisi'
    $divisi = Divisi::findOrFail($id);  // Pastikan parameter 'id' ini adalah 'id_divisi'
    return view('admin.divisi.edit', compact('divisi'));
}

public function update(Request $request, $id)
{
    // Mengubah 'id' menjadi 'id_divisi'
    $divisi = Divisi::findOrFail($id);  // Pastikan parameter 'id' ini adalah 'id_divisi'
    $divisi->update([
        'nama_divisi' => $request->nama_divisi,
        'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil diperbarui');
}

public function destroy($id)
{
    // Mengubah 'id' menjadi 'id_divisi'
    $divisi = Divisi::findOrFail($id);  // Pastikan parameter 'id' ini adalah 'id_divisi'
    $divisi->delete();

    return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil dihapus');
}

}
