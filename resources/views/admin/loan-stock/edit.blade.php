@extends('layouts.app')

@section('title', 'Edit Buku - Kelola Stok Peminjaman')

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

    /* Reuse orders pagination and button styles so edit page matches */
    .page-actions .btn-green {
        background: #a3e635; color: #1e3e2a; padding: 0.5rem 1rem; border-radius: .5rem; font-weight:700;
    }

</style>

<div class="w-full py-6" style="margin: 0 !important; padding: 0 1rem 0 0 !important;">
    <!-- Header similar to Orders page -->
    <div class="text-white rounded-2xl p-8 mb-6 text-center border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-col items-center justify-center gap-3">
            <h1 class="text-4xl font-bold" style="color: #a3e635;">✏️ Edit Buku</h1>
            <p class="text-white/90 text-sm">Perbarui judul, penulis, kategori, dan sampul buku</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 max-w-4xl mx-auto">
        <div class="p-6">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.loan-stock.update.details', $loanBook->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $loanBook->judul) }}" required class="w-full px-4 py-2 border rounded">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $loanBook->penulis) }}" class="w-full px-4 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-2 border rounded">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c }}" {{ old('kategori', $loanBook->kategori) == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $loanBook->penerbit) }}" class="w-full px-4 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn', $loanBook->isbn) }}" class="w-full px-4 py-2 border rounded">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Halaman</label>
                        <input type="number" name="halaman" value="{{ old('halaman', $loanBook->halaman) }}" min="1" class="w-full px-4 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Sampul</label>
                        <div class="flex items-center gap-4">
                            <input type="file" name="image" accept="image/*">
                            @if($loanBook->image)
                                <img src="{{ asset('storage/book-covers/' . $loanBook->image) }}" alt="cover" class="h-20 rounded border">
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border rounded">{{ old('deskripsi', $loanBook->deskripsi) }}</textarea>
                </div>

                <div class="flex gap-2 justify-end page-actions">
                    <a href="{{ route('admin.loan-stock.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                    <button type="submit" class="px-4 py-2 btn-green rounded font-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
