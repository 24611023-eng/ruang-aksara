@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
<style>
    body {
        background: 
            linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)),
            url('/images/background.jpg') center/cover fixed no-repeat !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        min-height: 100vh !important;
        overflow-x: hidden !important;
    }
</style>

<div class="w-full py-6" style="margin: 0 !important; padding: 0 1rem 0 0 !important;">
    <div class="text-white rounded-2xl p-8 mb-6 border-2 max-w-4xl w-full mx-auto" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-row gap-8 items-center">
            <div class="flex-1">
                <h1 class="text-5xl font-bold" style="color: #a3e635;">➕ Tambah Pegawai</h1>
                <p class="text-white/90 text-base mt-2">Buat akun pegawai baru untuk sistem administrasi</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('admin.employees.index') }}" class="inline-block text-white px-6 py-3 rounded-lg transition font-medium" style="background: #64748b;">Kembali ke Daftar</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full mx-auto">
        @if($errors->any())
            <div class="mb-3 p-3 bg-red-50 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Posisi / Hak</label>
                <input type="text" name="position" value="{{ old('position') }}" class="w-full border p-2 rounded" placeholder="contoh: kasir, logistik, admin stok">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" inputmode="numeric" maxlength="16" pattern="^[0-9]{16}$" title="NIK harus berisi 16 angka" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex gap-2">
                <button class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg">Simpan</button>
                <a href="{{ route('admin.employees.index') }}" class="inline-block px-6 py-3 rounded-lg border">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
