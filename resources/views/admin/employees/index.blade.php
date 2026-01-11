@extends('layouts.app')

@section('title', 'Kelola Pegawai - Admin')

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
    <div class="text-white rounded-2xl p-8 mb-6 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-row gap-8 items-center">
            <div class="flex-1">
                @php
                    $employeesCount = (method_exists($employees, 'total') ? $employees->total() : (is_countable($employees) ? count($employees) : 0));
                @endphp
                <h1 class="text-5xl font-bold" style="color: #a3e635;">👥 Kelola Pegawai</h1>
                <p class="text-white/90 text-base mt-2">Tambah, edit, dan hapus data pegawai administrasi</p>
                <p class="text-sm text-green-100 mt-2">Tersedia: <strong class="text-white">{{ $employeesCount }}</strong> pegawai</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('admin.employees.create') }}" class="inline-block text-white px-6 py-3 rounded-lg transition font-medium" style="background: #16a34a;">Tambah Pegawai</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-3 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-3 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Posisi / Hak</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $emp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $emp->name }}</td>
                            <td class="px-4 py-3">{{ $emp->email }}</td>
                            <td class="px-4 py-3">{{ $emp->position ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.employees.edit', $emp) }}" class="text-blue-600 mr-3">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pegawai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center" colspan="4">Belum ada pegawai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
