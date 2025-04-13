<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Display the list of users
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    // Show the form to create a new user
    public function create()
    {
        $divisis = Divisi::all();  // Retrieve all divisi data
        return view('admin.user.create', compact('divisis'));
    }

    // Store a new user in the database
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
        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil ditambahkan');
    }

    // Show the form to edit an existing user
    public function edit($id)
    {
        // Retrieve the user and associated divisis
        $user = User::findOrFail($id);
        $divisis = Divisi::all(); // Retrieve all divisi data for the dropdown

        return view('admin.user.edit', compact('user', 'divisis'));
    }

    // Update an existing user in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
            'role' => 'required|in:admin,karyawan,penilai,kepala sekolah',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Handle profile picture update if role is 'karyawan'
        if ($request->role === 'karyawan') {
            $request->validate([
                'nip' => 'required|unique:karyawans,nip,' . optional($user->karyawan)->id_karyawan . ',id_karyawan',
                'no_hp' => 'required',
                'alamat' => 'required',
                'tgl_masuk' => 'required|date',
                'id_divisi' => 'required|exists:divisis,id_divisi',
            ]);

            $fotoProfilName = optional($user->karyawan)->foto_profil;

            if ($request->hasFile('foto_profil')) {
                // Delete old photo if exists
                if ($fotoProfilName && Storage::exists('public/images/foto_profil/' . $fotoProfilName)) {
                    Storage::delete('public/images/foto_profil/' . $fotoProfilName);
                }

                // Upload the new photo
                $foto = $request->file('foto_profil');
                $fotoProfilName = Str::random(40) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('images/foto_profil', $fotoProfilName, 'public');
                // dd(storage_path('app/public/images/foto_profil/'.$fotoProfilName));

                // dd($path);

            }

            // Update or create Karyawan record
            $user->karyawan()->updateOrCreate(
                ['id_user' => $user->id_user],
                [
                    'nip' => $request->nip,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'tgl_masuk' => $request->tgl_masuk,
                    'id_divisi' => $request->id_divisi,
                    'foto_profil' => $fotoProfilName,
                ]
            );
        }

        // Redirect back with success message
        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui');
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
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
