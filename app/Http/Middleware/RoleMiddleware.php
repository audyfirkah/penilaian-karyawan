<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Jika role pengguna tidak termasuk dalam daftar yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Cek role pengguna dan arahkan ke halaman yang sesuai
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('warning', 'Anda tidak memiliki akses ke halaman ini.');
                case 'karyawan':
                    return redirect()->route('karyawan.dashboard')->with('warning', 'Anda tidak memiliki akses ke halaman ini.');
                case 'penilai':
                    return redirect()->route('penilai.dashboard')->with('warning', 'Anda tidak memiliki akses ke halaman ini.');
                case 'kepala':
                    return redirect()->route('kepala.dashboard')->with('warning', 'Anda tidak memiliki akses ke halaman ini.');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali, silakan login ulang.');
            }
        }

        // Lanjutkan permintaan jika role pengguna sesuai
        return $next($request);
    }
}
