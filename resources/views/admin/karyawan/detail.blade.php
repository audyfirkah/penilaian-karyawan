@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto space-y-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Detail Karyawan: {{ $karyawan->user->nama }}</h1>

    <!-- Foto Profil -->
    <div class="flex justify-center">
        <img src="{{ $karyawan->foto_profil ? asset('storage/images/foto_profil/' . $karyawan->foto_profil) : asset('default-avatar.png') }}"
             alt="Foto Profil {{ $karyawan->user->nama }}"
             class="w-32 h-32 rounded-full shadow-md object-cover border-4 border-gray-200">
    </div>

    <!-- Table Layout for Data -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Informasi</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Nama</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $karyawan->user->nama }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Email</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $karyawan->user->email }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">No HP</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $karyawan->no_hp }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Alamat</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $karyawan->alamat }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Divisi</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $karyawan->divisi->nama_divisi }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Tanggal Masuk</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d M Y') }}</td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">Role</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($karyawan->user->role) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
        <a href="{{ route('admin.karyawan.index') }}" class="text-gray-900 px-6 py-2 rounded-lg flex items-center space-x-2 transition hover:bg-gray-100">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>

        <!-- Tombol Lihat Jurnal -->
        <a href="{{ route('admin.jurnal.show', $karyawan->id_karyawan) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition">
            <i class="fas fa-book"></i>
            <span>Lihat Jurnal</span>
        </a>
    </div>
</div>
@endsection

