<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPenilaian;

class PenilaiKategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPenilaian::all();
        return view('penilai.kategori_penilaian.index', compact('kategoris'));
    }

    public function create()
    {
        return view('penilai.kategori_penilaian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriPenilaian::create($request->all());

        return redirect()->route('penilai.kategori-penilaian.index')->with('success', 'Kategori penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriPenilaian::findOrFail($id);
        return view('penilai.kategori_penilaian.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriPenilaian::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('penilai.kategori-penilaian.index')->with('success', 'Kategori penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriPenilaian::findOrFail($id);
        $kategori->delete();

        return redirect()->route('penilai.kategori-penilaian.index')->with('success', 'Kategori penilaian berhasil dihapus.');
    }
}
