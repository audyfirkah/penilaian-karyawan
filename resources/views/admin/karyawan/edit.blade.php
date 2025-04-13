@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Karyawan</h1>

    <form action="{{ route('admin.karyawan.update', $karyawan->user->id_user) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Data User -->
        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $karyawan->user->nama) }}" class="w-full border px-4 py-2 rounded" required>
            @error('nama') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $karyawan->user->email) }}" class="w-full border px-4 py-2 rounded" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Password (Kosongkan jika tidak diubah)</label>
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
            <input type="text" name="nip" value="{{ old('nip', $karyawan->nip) }}" class="w-full border px-4 py-2 rounded" required>
            @error('nip') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" class="w-full border px-4 py-2 rounded" required>
            @error('no_hp') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Alamat</label>
            <textarea name="alamat" class="w-full border px-4 py-2 rounded" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
            @error('alamat') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $karyawan->tgl_masuk) }}" class="w-full border px-4 py-2 rounded" required>
            @error('tgl_masuk') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Divisi</label>
            <select name="id_divisi" class="w-full border px-4 py-2 rounded" required>
                <option value="">Pilih Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi', $karyawan->id_divisi) == $divisi->id_divisi ? 'selected' : '' }}>
                        {{ $divisi->nama_divisi }}
                    </option>
                @endforeach
            </select>
            @error('id_divisi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Foto Profil -->
        <div>
            <label for="foto_profil" class="block text-gray-700 font-medium mb-1">Foto Profil</label>
            <input type="file" name="foto_profil" id="foto_profil"
                class="w-full px-4 py-2 border rounded @error('foto_profil') border-red-500 @enderror" accept="image/*">
            @error('foto_profil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="mt-2">
                <img id="previewFoto"
                    src="{{ $karyawan->foto_profil ? asset('storage/images/foto_profil/' . $karyawan->foto_profil) : asset('default-avatar.png') }}"
                    alt="Preview Foto"
                    class="w-32 h-32 object-cover rounded border {{ $karyawan->foto_profil ? '' : 'hidden' }}">
            </div>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.karyawan.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fotoInput = document.getElementById('foto_profil');
        const previewFoto = document.getElementById('previewFoto');

        fotoInput?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file && previewFoto) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
