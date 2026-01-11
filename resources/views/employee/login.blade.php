@extends('layouts.app')

@section('content')
@include('employee.partials.styles')

<div class="employee-auth">
    <div class="employee-auth__card">
        <h2>Masuk Pegawai</h2>
        <p>Akses panel internal Ruang Aksara dengan kredensial resmi tim.</p>

        @if($errors->any())
            <div class="employee-alert employee-alert--error">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('employee.login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label>Email Pegawai</label>
                <input name="email" type="email" value="{{ old('email') }}" required autocomplete="username">
            </div>

            <div>
                <label>Password</label>
                <input name="password" type="password" required autocomplete="current-password">
            </div>

            <div class="employee-actions">
                <button type="submit" class="employee-btn employee-btn--primary flex-1 justify-center">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
                <a href="{{ url('/') }}" class="employee-btn employee-btn--ghost flex-1 justify-center">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </form>

        <p class="employee-auth__meta mt-4">
            Hubungi admin jika mengalami kendala akses akun pegawai.
        </p>
    </div>
</div>
@endsection
