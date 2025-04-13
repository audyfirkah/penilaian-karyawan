@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Karyawan</h1>

    <form action="{{ route('admin.karyawan.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Data User -->
        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border px-4 py-2 rounded">
            @error('nama') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border px-4 py-2 rounded">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password" class="w-full border px-4 py-2 rounded">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border px-4 py-2 rounded">
        </div>

        <!-- Data Karyawan -->
        <div>
            <label class="block mb-1 font-medium">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border px-4 py-2 rounded">
            @error('nip') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border px-4 py-2 rounded">
            @error('no_hp') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Alamat</label>
            <textarea name="alamat" class="w-full border px-4 py-2 rounded">{{ old('alamat') }}</textarea>
            @error('alamat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}" class="w-full border px-4 py-2 rounded">
            @error('tgl_masuk') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Divisi</label>
            <select name="id_divisi" class="w-full border px-4 py-2 rounded">
                <option value="">Pilih Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->id_divisi }}">{{ $divisi->nama_divisi }}</option>
                @endforeach
            </select>
            @error('id_divisi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.karyawan.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan Karyawan
            </button>
        </div>
    </form>
</div>
@endsection
