<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Ambil user yang sedang login
            $user = Auth::user();

            // Arahkan sesuai role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'karyawan':
                    return redirect()->route('karyawan.dashboard');
                case 'penilai':
                    return redirect()->route('penilai.dashboard');
                case 'kepala sekolah':
                    return redirect()->route('kepala.dashboard');
                default:
                    Auth::logout(); // logout jika role tidak dikenal
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
