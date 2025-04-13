<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;


class KaryawanJurnalController extends Controller
{
      public function show($id)
    {
        $user = Auth::user();

        // dd($user->karyawan->id_karyawan);

        if ($user->karyawan->id_karyawan != $id) {
            abort(403); // akses ditolak kalau bukan jurnal miliknya
        }

        $jurnals = Jurnal::with(['karyawan.user'])
            ->where('id_karyawan', $id)
            ->latest()
            ->get();

        return view('karyawan.jurnal.index', compact('jurnals'));
    }

    public function create($id)
{
    $user = Auth::user();
    if ($user->karyawan->id_karyawan != $id) {
            abort(403); // akses ditolak kalau bukan jurnal miliknya
        }

    return view('karyawan.jurnal.create');
}

public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'aktivitas' => 'required|string|max:255',
        'lampiran' => 'nullable|file|mimes:docx,mp4,pdf,jpg,png|max:2048',
    ]);

    $jurnal = new Jurnal();
    $jurnal->id_karyawan = Auth::user()->karyawan->id_karyawan;
    $jurnal->tanggal = $request->tanggal;
    $jurnal->aktivitas = $request->aktivitas;

    if ($request->hasFile('lampiran')) {
        $lampiran = $request->file('lampiran')->store('lampiran_jurnal', 'public');
        $jurnal->lampiran = basename($lampiran);
    }

    $jurnal->save();

    return redirect()->route('karyawan.jurnal.show', $jurnal->id_karyawan)->with('success', 'Jurnal berhasil ditambahkan.');
}

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('karyawan.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'aktivitas' => 'required|string|max:255',
            'lampiran' => 'nullable|file|mimes:docx,mp4,pdf,jpg,png|max:2048',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->tanggal = $request->tanggal;
        $jurnal->aktivitas = $request->aktivitas;

        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($jurnal->lampiran && file_exists(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran))) {
                unlink(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran));
            }

            $lampiran = $request->file('lampiran')->store('lampiran_jurnal', 'public');
            $jurnal->lampiran = basename($lampiran);
        }

        $jurnal->save();

        return redirect()->route('karyawan.jurnal.show', $jurnal->id_karyawan)->with('success')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        // Hapus lampiran jika ada
        if ($jurnal->lampiran && file_exists(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran))) {
            unlink(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran));
        }

        $jurnal->delete();

        return redirect()->route('karyawan.jurnal.show', $jurnal->id_karyawan)->with('success')->with('success', 'Jurnal berhasil dihapus.');
    }
}
