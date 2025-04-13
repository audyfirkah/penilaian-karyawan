@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

{{-- @dd($user->karyawan) --}}
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data User</h1>

    <?= asset('storage/image/foto_profil/' . $user->karyawan->foto_profil) ?>

    <form action="{{ route('admin.user.update', $user->id_user) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label for="nama" class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                class="w-full px-4 py-2 border rounded @error('nama') border-red-500 @enderror" required>
            @error('nama')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full px-4 py-2 border rounded @error('role') border-red-500 @enderror" required>
                @php $roles = ['admin', 'kepala sekolah', 'karyawan', 'penilai']; @endphp
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            @error('role')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Karyawan Fields --}}
        <div id="karyawanFields" class="space-y-4 {{ old('role', $user->role) == 'karyawan' ? '' : 'hidden' }}">
            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip', optional($user->karyawan)->nip) }}"
                    class="w-full px-4 py-2 border rounded @error('nip') border-red-500 @enderror">
                @error('nip')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label for="no_hp" class="block text-gray-700 font-medium mb-1">No HP</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', optional($user->karyawan)->no_hp) }}"
                    class="w-full px-4 py-2 border rounded @error('no_hp') border-red-500 @enderror">
                @error('no_hp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block text-gray-700 font-medium mb-1">Alamat</label>
                <textarea name="alamat" id="alamat"
                    class="w-full px-4 py-2 border rounded @error('alamat') border-red-500 @enderror">{{ old('alamat', optional($user->karyawan)->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label for="tgl_masuk" class="block text-gray-700 font-medium mb-1">Tanggal Masuk</label>
                <input type="date" name="tgl_masuk" id="tgl_masuk" value="{{ old('tgl_masuk', optional($user->karyawan)->tgl_masuk) }}"
                    class="w-full px-4 py-2 border rounded @error('tgl_masuk') border-red-500 @enderror">
                @error('tgl_masuk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Divisi --}}
            <div>
                <label for="id_divisi" class="block text-gray-700 font-medium mb-1">Divisi</label>
                <select name="id_divisi" id="id_divisi" class="w-full px-4 py-2 border rounded @error('id_divisi') border-red-500 @enderror">
                    <option value="">Pilih Divisi</option>
                    @foreach ($divisis as $divisi)
                        <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi', optional($user->karyawan)->id_divisi) == $divisi->id_divisi ? 'selected' : '' }}>
                            {{ $divisi->nama_divisi }}
                        </option>
                    @endforeach
                </select>
                @error('id_divisi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Foto Profil --}}
            <div>
                <label for="foto_profil" class="block text-gray-700 font-medium mb-1">Foto Profil</label>
                <input type="file" name="foto_profil" id="foto_profil"
                    class="w-full px-4 py-2 border rounded @error('foto_profil') border-red-500 @enderror" accept="image/*">
                @error('foto_profil')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="mt-2">
                    <img id="previewFoto"
                src="{{ $user->karyawan && $user->karyawan->foto_profil ? asset('storage/images/foto_profil/' . $user->karyawan->foto_profil) : asset('default-avatar.png') }}"
                alt="Preview Foto"
                class="w-32 h-32 object-cover rounded border {{ $user->karyawan && $user->karyawan->foto_profil ? '' : 'hidden' }}">

                </div>
            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.user.index') }}" class="text-gray-600 hover:underline">
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
        const roleSelect = document.getElementById('role');
        const karyawanFields = document.getElementById('karyawanFields');
        const fotoInput = document.getElementById('foto_profil');
        const previewFoto = document.getElementById('previewFoto');

        // Tampilkan atau sembunyikan field karyawan berdasarkan role
        function toggleKaryawanFields() {
            const isKaryawan = roleSelect.value === 'karyawan';
            karyawanFields.classList.toggle('hidden', !isKaryawan);
        }

        // Preview foto ketika file dipilih
        function previewFotoProfil(event) {
            const file = event.target.files[0];
            if (file && previewFoto) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        roleSelect.addEventListener('change', toggleKaryawanFields);
        fotoInput?.addEventListener('change', previewFotoProfil);
        toggleKaryawanFields();
    });
</script>
@endsection
