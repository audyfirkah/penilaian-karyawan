<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;

class JurnalController extends Controller
{
    public function show($id)
    {
        // Ambil semua data jurnal dengan relasi ke karyawan dan user
        $jurnals = Jurnal::with(['karyawan.user'])
            ->where('id_karyawan', $id)->latest()->get();

        return view('admin.jurnal.index', compact('jurnals'));
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('admin.jurnal.edit', compact('jurnal'));
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

        return redirect()->route('admin.jurnal.show', $jurnal->id_karyawan)->with('success')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        // Hapus lampiran jika ada
        if ($jurnal->lampiran && file_exists(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran))) {
            unlink(storage_path('app/public/lampiran_jurnal/' . $jurnal->lampiran));
        }

        $jurnal->delete();

        return redirect()->route('admin.jurnal.show', $jurnal->id_karyawan)->with('success')->with('success', 'Jurnal berhasil dihapus.');
    }
}
