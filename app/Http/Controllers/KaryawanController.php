<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Divisi;

class KaryawanController extends Controller
{
    public function index()
{
    $karyawans = User::where('role', 'karyawan')->with('karyawan', 'divisi' )->get();
    return view('admin.karyawan.index', compact('karyawans'));
}

public function create()
{
    $divisis = Divisi::all();
    return view('admin.karyawan.create', compact('divisis'));
}

 public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,karyawan,penilai,kepala sekolah',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload for profile picture
        $fotoProfilName = null;

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fotoProfilName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // Save the image to storage
            $file->storeAs('images/foto_profil', $fotoProfilName, 'public');
            // dd($file);

        }

        // Create the new user
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // If the role is 'karyawan', create a related Karyawan record
        if ($request->role === 'karyawan') {
            $request->validate([
                'nip' => 'required|unique:karyawans,nip',
                'no_hp' => 'required',
                'alamat' => 'required',
                'tgl_masuk' => 'required|date',
                'id_divisi' => 'required|exists:divisis,id_divisi',
            ]);

            Karyawan::create([
                'id_user' => $user->id_user,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'tgl_masuk' => $request->tgl_masuk,
                'id_divisi' => $request->id_divisi,
                'foto_profil' => $fotoProfilName,
            ]);
        }

        // Redirect back with success message
        return redirect()->route('admin.karyawan.index')->with('success', 'Data user berhasil ditambahkan');
    }

    // Show the form to edit an existing user
    // Show the form to edit an existing user
public function edit($id)
{
    $user = User::findOrFail($id); // Mengambil user berdasarkan id_user
    $karyawan = $user->karyawan; // Mengambil data karyawan terkait
    $divisis = Divisi::all();

    return view('admin.karyawan.edit', compact('karyawan', 'divisis'));
}

// Update an existing karyawan
public function update(Request $request, $id)
{
    $user = User::findOrFail($id); // Mengambil user berdasarkan id_user
    $karyawan = $user->karyawan;

    // dd($user->id_user);

    // Validasi data user
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
        'password' => 'nullable|min:6|confirmed',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update data user
    $user->nama = $request->nama;
    $user->email = $request->email;
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    // Validasi data karyawan
    $request->validate([
        'nip' => 'required|unique:karyawans,nip,' . $karyawan->id_karyawan . ',id_karyawan',
        'no_hp' => 'required',
        'alamat' => 'required',
        'tgl_masuk' => 'required|date',
        'id_divisi' => 'required|exists:divisis,id_divisi',
    ]);

    $fotoProfilName = $karyawan->foto_profil;

    // Jika upload foto baru
    if ($request->hasFile('foto_profil')) {
        if ($fotoProfilName && Storage::disk('public')->exists('images/foto_profil/' . $fotoProfilName)) {
            Storage::disk('public')->delete('images/foto_profil/' . $fotoProfilName);
        }

        $file = $request->file('foto_profil');
        $fotoProfilName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('images/foto_profil', $fotoProfilName, 'public');
    }

    // Update data karyawan
    $karyawan->update([
        'nip' => $request->nip,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'tgl_masuk' => $request->tgl_masuk,
        'id_divisi' => $request->id_divisi,
        'foto_profil' => $fotoProfilName,
    ]);

    return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
}


    // Delete a user from the database
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete related Karyawan record if the user is a karyawan
        if ($user->role === 'karyawan') {
            $karyawan = $user->karyawan;
            if ($karyawan && $karyawan->foto_profil) {
                Storage::delete('images/foto_profil/' . $karyawan->foto_profil);
            }
            $karyawan->delete();
        }

        // Delete the user record
        $user->delete();

        // Redirect back with success message
        return redirect()->route('admin.karyawan.index')->with('success', 'User berhasil dihapus');
    }

public function detail($id)
{
    $karyawan = Karyawan::findOrFail($id);
    return view('admin.karyawan.detail', compact('karyawan'));
}

}
