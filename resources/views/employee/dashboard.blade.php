@extends('layouts.app')

@section('content')
@include('employee.partials.styles')

@php
    $attendanceStatus = $attendance ? ($attendance->status_label ?? ($attendance->status ?? 'Belum Presensi')) : 'Belum Presensi';
    $checkInTime = $attendance->check_in ?? '—';
    $checkOutTime = $attendance->check_out ?? '—';
@endphp

<!-- HEADER BANNER ala katalog buku -->
<div class="employee-hero-banner">
    <div class="employee-hero-inner">
        <div class="employee-hero-title flex items-center gap-2">
            @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
                <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Ruang Aksara" class="h-12 mr-0 inline-block" />
            @else
                <img src="{{ asset('images/ruang-aksara-logo.svg') }}" alt="Ruang Aksara" class="h-12 mr-0 inline-block" />
            @endif
            <div>
                <div class="text-xl font-bold" style="color:#FFD600">Ruang Aksara</div>
                <div class="text-base">Presensi Harian</div>
            </div>
        </div>
        <p class="employee-hero-subtitle">
            Pantau check-in, check-out, dan status presensi kamu di satu tempat.
        </p>
    </div>
</div>

<div class="employee-shell">

    <div class="employee-grid employee-grid--stats">
        <article class="employee-card employee-card--stat">
            <p class="employee-card__label">Check-in</p>
            <p class="employee-card__value">{{ $checkInTime }}</p>
            <p class="employee-card__helper">Catat jam kehadiran pertamamu hari ini.</p>
        </article>

        <article class="employee-card employee-card--stat">
            <p class="employee-card__label">Check-out</p>
            <p class="employee-card__value">{{ $checkOutTime }}</p>
            <p class="employee-card__helper">Selesaikan shift dengan presensi pulang.</p>
        </article>

        <article class="employee-card employee-card--stat">
            <p class="employee-card__label">Status Presensi</p>
            <p class="employee-card__value text-2xl">{{ $attendanceStatus }}</p>
            <p class="employee-card__helper">
                @if($attendance)
                    Data terakhir diperbarui otomatis.
                @else
                    Tekan tombol presensi untuk memulai hari.
                @endif
            </p>
        </article>
    </div>

    <div class="employee-grid">
        <article class="employee-card">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-600"></i>
                Catatan Presensi
            </h2>
            <p class="text-gray-600 mt-3">Pastikan mengikuti alur berikut agar data absensi akurat.</p>
            <div class="employee-divider"></div>
            <ul class="employee-info-list">
                <li><i class="fas fa-check text-emerald-500"></i> Pastikan lokasi di lingkungan Ruang Aksara saat presensi.</li>
                <li><i class="fas fa-clock text-amber-500"></i> Lakukan presensi masuk maksimal 10 menit setelah tiba.</li>
                <li><i class="fas fa-sign-out-alt text-rose-500"></i> Presensi pulang hanya dapat dilakukan setelah tugas selesai.</li>
                <li><i class="fas fa-user-cog text-indigo-500"></i> Perbarui profil jika ada perubahan data pribadi.</li>
            </ul>
        </article>

        <article class="employee-card employee-card--actions">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-play-circle text-emerald-500"></i>
                Aksi Hari Ini
            </h2>
            <div class="employee-actions">
                <form method="POST" action="{{ route('attendance.checkin') }}" class="employee-inline-form">
                    @csrf
                    <button type="submit" class="employee-btn employee-btn--primary">
                        <i class="fas fa-door-open"></i>
                        Presensi Masuk
                    </button>
                </form>

                <form method="POST" action="{{ route('attendance.checkout') }}" class="employee-inline-form">
                    @csrf
                    <button type="submit" class="employee-btn employee-btn--accent">
                        <i class="fas fa-door-closed"></i>
                        Presensi Pulang
                    </button>
                </form>
            </div>

            <div class="employee-divider"></div>

            <div class="employee-actions">
                <a href="{{ route('employee.profile') }}" class="employee-btn employee-btn--ghost">
                    <i class="fas fa-user-edit"></i>
                    Kelola Profil
                </a>

                <form method="POST" action="{{ route('employee.logout') }}" class="employee-inline-form">
                    @csrf
                    <button type="submit" class="employee-btn employee-btn--danger">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </article>
    </div>
</div>
@endsection
