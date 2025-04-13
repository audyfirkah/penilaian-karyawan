<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Jika pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Hindari redirect loop jika user sudah di halaman tujuan
            if ($request->routeIs('login')) {
                // Redirect berdasarkan role pengguna
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'karyawan' => redirect()->route('karyawan.dashboard'),
                    'penilai' => redirect()->route('penilai.dashboard'),
                    'kepala' => redirect()->route('kepala.dashboard'),
                    default => redirect()->route('login'),
                };
            }
        }

        return $next($request);
    }
}
