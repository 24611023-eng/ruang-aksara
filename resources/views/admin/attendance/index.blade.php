@extends('layouts.app')

@section('title', 'Presensi ' . (auth()->user()->role === 'owner' ? 'Owner' : 'Admin') . ' - Ruang Aksara')

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
    <!-- Header -->
    <div class="text-white rounded-2xl p-8 mb-6 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-row gap-8 items-center">
            <!-- Title Section -->
            <div class="flex-1">
                <h1 class="text-5xl font-bold" style="color: #a3e635;">
                    👤 Presensi {{ auth()->user()->role === 'owner' ? 'Owner' : 'Admin' }}
                </h1>
                <p class="text-white/90 text-base mt-2">Kelola kehadiran dan jam kerja staff administrasi</p>
            </div>
            <!-- Button Section -->
            @if(auth()->user() && auth()->user()->role === 'owner')
                @php
                    $ownerRoute = 'owner.attendance.detail';
                    $adminRoute = 'admin.attendance.detail';
                @endphp
                <div class="flex-shrink-0">
                    <a href="{{ \Illuminate\Support\Facades\Route::has($ownerRoute) ? route($ownerRoute) : (\Illuminate\Support\Facades\Route::has($adminRoute) ? route($adminRoute) : url('/owner/attendance/detail')) }}" class="inline-block text-white px-6 py-3 rounded-lg transition font-medium" style="background: #fbbf24; color: #1e3e2a;">
                        <i class="fas fa-list mr-2"></i>Lihat Detail Presensi Semua Staff
                    </a>
                </div>
            @endif
        </div>
    </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Check In/Out Button -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Today's Status -->
                <div class="border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-2">Status Hari Ini</p>
                    @php
                        $today = \App\Models\Attendance::where('user_id', Auth::id())
                            ->where('date', today()->toDateString())
                            ->first();
                    @endphp
                    
                    @if($today && $today->check_in)
                        <div class="text-green-600 font-bold text-lg mb-2">
                            <i class="fas fa-check-circle mr-1"></i>Sudah Check-In
                        </div>
                        <p class="text-sm text-gray-700">Jam Masuk: <strong>{{ \Carbon\Carbon::parse($today->check_in)->format('H:i') }}</strong></p>
                        @if($today->check_out)
                            <p class="text-sm text-gray-700">Jam Keluar: <strong>{{ \Carbon\Carbon::parse($today->check_out)->format('H:i') }}</strong></p>
                            <p class="text-sm text-gray-700 mt-2">Status: <strong class="text-green-600">Sudah Selesai</strong></p>
                        @else
                            <form action="{{ route('admin.attendance.checkout') }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 w-full">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Check-Out Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="text-gray-500 font-bold text-lg mb-2">
                            <i class="fas fa-times-circle mr-1"></i>Belum Check-In
                        </div>
                        <form action="{{ route('admin.attendance.checkin') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full">
                                <i class="fas fa-sign-in-alt mr-2"></i>Check-In Sekarang
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Today's Details -->
                <div class="border border-purple-200 rounded-lg p-4 bg-purple-50">
                    <p class="text-sm text-gray-600 mb-2">Informasi Hari Ini</p>
                    <p class="text-sm text-gray-700">Tanggal: <strong>{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</strong></p>
                    <p class="text-sm text-gray-700 mt-2">Nama: <strong>{{ Auth::user()->name }}</strong></p>
                    <p class="text-sm text-gray-700">Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>
                    <p class="text-sm text-gray-700 mt-2">Waktu Sekarang: <strong id="current-time"></strong></p>
                </div>

                <!-- Monthly Stats -->
                <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                    <p class="text-sm text-gray-600 mb-2">Statistik Bulan Ini</p>
                    @php
                        $thisMonth = \App\Models\Attendance::where('user_id', Auth::id())
                            ->whereMonth('date', now()->month)
                            ->whereYear('date', now()->year)
                            ->get();
                        $checkedIn = $thisMonth->whereNotNull('check_in')->count();
                        $completed = $thisMonth->whereNotNull('check_out')->count();
                    @endphp
                    <p class="text-sm text-gray-700">Total Hari Kerja: <strong>{{ $checkedIn }}</strong></p>
                    <p class="text-sm text-gray-700">Selesai: <strong class="text-green-600">{{ $completed }}</strong></p>
                    <p class="text-sm text-gray-700">Tidak Selesai: <strong class="text-orange-600">{{ $checkedIn - $completed }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Attendance History Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Riwayat Presensi</h2>
                
                <!-- Filter -->
                <form method="GET" class="flex gap-4 mb-4">
                    <div class="flex gap-2 flex-1">
                        <select name="year" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Tahun --</option>
                            @for($y = 2020; $y <= now()->year; $y++)
                                <option value="{{ $y }}" {{ request()->input('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <select name="month_num" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="01" {{ request()->input('month_num') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ request()->input('month_num') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ request()->input('month_num') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ request()->input('month_num') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ request()->input('month_num') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ request()->input('month_num') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ request()->input('month_num') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ request()->input('month_num') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ request()->input('month_num') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request()->input('month_num') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request()->input('month_num') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request()->input('month_num') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <a href="{{ route('admin.attendance.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-redo mr-1"></i>Reset
                    </a>
                </form>
            </div>

            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Tanggal</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Hari</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Check-In</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Check-Out</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Durasi</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-800">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $record)
                        <tr class="border-b hover:bg-gray-50">
                            @php
                                $statusLabel = 'Tidak Hadir';
                                $statusIcon = 'fas fa-times-circle';
                                $statusClasses = 'bg-red-100 text-red-800';
                                $lateThreshold = \Carbon\Carbon::createFromTime(7, 30, 0);

                                if ($record->status === 'izin') {
                                    $statusLabel = 'Izin';
                                    $statusIcon = 'fas fa-info-circle';
                                    $statusClasses = 'bg-blue-100 text-blue-800';
                                } elseif ($record->status === 'sakit') {
                                    $statusLabel = 'Sakit';
                                    $statusIcon = 'fas fa-hospital';
                                    $statusClasses = 'bg-orange-100 text-orange-800';
                                } elseif ($record->check_in) {
                                    $checkInTime = \Carbon\Carbon::parse($record->check_in);
                                    if ($checkInTime->gt($lateThreshold) || $record->status === 'late') {
                                        $statusLabel = 'Terlambat';
                                        $statusIcon = 'fas fa-clock';
                                        $statusClasses = 'bg-yellow-100 text-yellow-800';
                                    } else {
                                        $statusLabel = 'Tepat Waktu';
                                        $statusIcon = 'fas fa-check-circle';
                                        $statusClasses = 'bg-green-100 text-green-800';
                                    }
                                } elseif ($record->status === 'late') {
                                    $statusLabel = 'Terlambat';
                                    $statusIcon = 'fas fa-clock';
                                    $statusClasses = 'bg-yellow-100 text-yellow-800';
                                } elseif ($record->status === 'ontime') {
                                    $statusLabel = 'Tepat Waktu';
                                    $statusIcon = 'fas fa-check-circle';
                                    $statusClasses = 'bg-green-100 text-green-800';
                                }
                            @endphp
                            <td class="px-6 py-3 font-semibold text-blue-600">
                                {{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-3">
                                {{ \Carbon\Carbon::parse($record->date)->translatedFormat('l') }}
                            </td>
                            <td class="px-6 py-3">
                                @if($record->check_in)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">
                                        {{ \Carbon\Carbon::parse($record->check_in)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($record->check_out)
                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded text-sm">
                                        {{ \Carbon\Carbon::parse($record->check_out)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if($record->check_in && $record->check_out)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($record->check_in);
                                        $checkOut = \Carbon\Carbon::parse($record->check_out);
                                        $duration = $checkOut->diff($checkIn)->format('%H jam %I menit');
                                    @endphp
                                    <span class="text-sm font-semibold">{{ $duration }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-sm {{ $statusClasses }}">
                                    <i class="{{ $statusIcon }} mr-1"></i>{{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">
                                {{ $record->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Tidak ada riwayat presensi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }
        
        setInterval(updateTime, 1000);
        updateTime();
    </script>
@endsection
