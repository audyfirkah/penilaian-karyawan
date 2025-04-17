<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JurnalRevisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class JurnalController extends Controller
{
    public function show($id)
    {
        // Ambil semua data jurnal dengan relasi ke karyawan dan user
        $jurnals = Jurnal::with(['karyawan.user'])
            ->where('id_karyawan', $id)
            ->orderByRaw("FIELD(status, 'revisi', 'pending', 'approved')")
            ->latest()
            ->get();

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

    public function revisi(Request $request, $id)
{

    try {
        $jurnal = Jurnal::findOrFail($id);

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

        if ($request->ajax()) {
            return response()->json(['message' => 'Revisi berhasil dikirim.']);
        }

        return back()->with('success', 'Revisi berhasil dikirim.');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan pada server'], 500);
    }

}


public function approve($id)
{
    $jurnal = Jurnal::findOrFail($id);

    JurnalRevisi::create([
        'id_jurnal' => $jurnal->id_jurnal,
        'id_user' => auth()->id(),
        'catatan' => 'Disetujui tanpa revisi',
        'status_sebelumnya' => $jurnal->status,
        'status_baru' => 'approved',
    ]);

    $jurnal->update(['status' => 'approved']);

    return back()->with('success', 'Jurnal disetujui.');
}


public function histori($id)
{
    $jurnals = Jurnal::where('id_karyawan', $id)->get();

        // Ambil data revisi jurnal yang terkait dengan jurnal karyawan
        $revisis = JurnalRevisi::whereHas('jurnal', function ($query) use ($id) {
            $query->where('id_karyawan', $id);
        })->get();

        // Tampilkan view dashboard karyawan dengan data jurnal dan revisi

    return view('karyawan.jurnal.histori', compact('jurnals', 'revisis'));
}
}
