@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Data User</h1>

    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="nama" class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                class="w-full px-4 py-2 border rounded @error('nama') border-red-500 @enderror" required>
            @error('nama')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-2 border rounded @error('password') border-red-500 @enderror" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full px-4 py-2 border rounded @error('role') border-red-500 @enderror" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kepala sekolah" {{ old('role') == 'kepala sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                <option value="penilai" {{ old('role') == 'penilai' ? 'selected' : '' }}>Penilai</option>
            </select>
            @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div id="karyawanFields" class="space-y-4 {{ old('role') == 'karyawan' ? '' : 'hidden' }}">
            <div>
                <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                    class="w-full px-4 py-2 border rounded @error('nip') border-red-500 @enderror">
                @error('nip')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="no_hp" class="block text-gray-700 font-medium mb-1">No HP</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                    class="w-full px-4 py-2 border rounded @error('no_hp') border-red-500 @enderror">
                @error('no_hp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="alamat" class="block text-gray-700 font-medium mb-1">Alamat</label>
                <textarea name="alamat" id="alamat" class="w-full px-4 py-2 border rounded @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="tgl_masuk" class="block text-gray-700 font-medium mb-1">Tanggal Masuk</label>
                <input type="date" name="tgl_masuk" id="tgl_masuk" value="{{ old('tgl_masuk') }}"
                    class="w-full px-4 py-2 border rounded @error('tgl_masuk') border-red-500 @enderror">
                @error('tgl_masuk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="id_divisi" class="block text-gray-700 font-medium mb-1">Divisi</label>
                <select name="id_divisi" id="id_divisi" class="w-full px-4 py-2 border rounded @error('id_divisi') border-red-500 @enderror">
                    <option value="">Pilih Divisi</option>
                    @foreach ($divisis as $divisi)
                        <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi') == $divisi->id_divisi ? 'selected' : '' }}>
                            {{ $divisi->nama_divisi }}
                        </option>
                    @endforeach
                </select>
                @error('id_divisi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="foto_profil" class="block text-gray-700 font-medium mb-1">Foto Profil</label>
                <input type="file" name="foto_profil" id="foto_profil"
                    class="w-full px-4 py-2 border rounded @error('foto_profil') border-red-500 @enderror" accept="image/*">
                @error('foto_profil')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-2">
                <img id="previewFoto" src="#" alt="Preview Foto" class="w-32 h-32 object-cover rounded hidden border">
            </div>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.user.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Simpan User
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const karyawanFields = document.getElementById('karyawanFields');
        const fotoInput = document.getElementById('foto_profil');
        const previewFoto = document.getElementById('previewFoto');

        function toggleKaryawanFields() {
            if (roleSelect.value === 'karyawan') {
                karyawanFields.classList.remove('hidden');
            } else {
                karyawanFields.classList.add('hidden');
                previewFoto.classList.add('hidden'); // sembunyikan preview kalau bukan karyawan
            }
        }

        roleSelect.addEventListener('change', toggleKaryawanFields);
        toggleKaryawanFields();

        fotoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
