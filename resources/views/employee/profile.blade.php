@extends('layouts.app')

@section('content')
@include('employee.partials.styles')

@push('styles')
<style>
    /* Header override to match green palette */
    .employee-hero {
        background: rgba(42, 71, 63, 0.78);
        border: 1.6px solid rgba(163, 230, 53, 0.8);
        border-radius: 22px;
        padding: 2.5rem 2rem;
        color: #f8fafc;
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.22);
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: flex-start;
    }
    .employee-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        background: rgba(190, 242, 100, 0.14);
        color: #d9f99d;
        font-weight: 700;
        letter-spacing: 0.03em;
        box-shadow: inset 0 0 0 1px rgba(190, 242, 100, 0.35);
    }
    .employee-hero h1 {
        color: #ecfccb;
    }
    .employee-hero p {
        color: #e2e8f0;
    }
    .employee-hero__actions .employee-btn--ghost {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #f8fafc;
    }
    @media (max-width: 640px) {
        .employee-hero {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush

@php
    $birthDate = $employee && $employee->tanggal_lahir
        ? \Illuminate\Support\Carbon::parse($employee->tanggal_lahir)->format('Y-m-d')
        : '';
@endphp

@php
    $isOwner = auth()->check() && auth()->user()->role === 'owner';
@endphp

<div class="employee-shell">
    <section class="employee-hero">
        <div>
            <p class="employee-hero__badge">
                <i class="fas fa-user-shield"></i>
                Profil Pegawai
            </p>
            <h1 class="text-3xl font-bold mt-3">{{ $employee->name ?? 'Pegawai' }}</h1>
            <p class="mt-2 text-base text-white/90">Perbarui identitas, kontak, dan kredensial untuk memastikan administrasi berjalan rapi.</p>
        </div>
        <div class="employee-hero__actions">
            <a href="{{ route('employee.dashboard') }}" class="employee-btn employee-btn--ghost">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </section>

    @if($employee)
        <div class="employee-grid employee-grid--profile employee-stack-gap">
            <article class="employee-card text-center">
                <div class="employee-avatar">
                    @if($employee->foto_profil && file_exists(public_path('storage/' . $employee->foto_profil)))
                        <img src="{{ asset('storage/' . $employee->foto_profil) }}" alt="{{ $employee->name }}">
                    @else
                        <i class="fas fa-user fa-3x text-gray-500"></i>
                    @endif
                </div>
                <button id="ubah-foto-btn" type="button" class="employee-btn employee-btn--ghost w-full justify-center">
                    <i class="fas fa-camera"></i>
                    Ubah Foto
                </button>
                <p class="employee-form-note">Format jpg/png maksimal 5MB.</p>
                <input type="file" id="foto_profil_input" class="hidden" accept="image/*">
            </article>

            <article class="employee-card">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Data Diri</h2>

                @if(session('success'))
                    <div class="employee-alert employee-alert--success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="employee-alert employee-alert--error">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form id="employee-profile-form" action="{{ route('employee.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="employee-form-grid employee-form-grid--two-cols">
                        <div class="employee-form-group">
                            <label>Nama Lengkap @if(!$isOwner)<span class="text-sm text-gray-500">(diisi oleh owner)</span>@endif</label>
                            <input id="employee-name" type="text" name="name" value="{{ old('name', $employee->name) }}" @if(!$isOwner) readonly @endif required pattern="^[\p{L} \.-']+$" title="Hanya huruf, spasi, titik, atau tanda hubung" />
                            <div id="name-error" class="text-red-600 text-sm mt-1" aria-live="polite"></div>
                        </div>
                        <div class="employee-form-group">
                            <label>Email (tidak dapat diubah)</label>
                            <input type="email" value="{{ $employee->email }}" disabled readonly>
                        </div>
                    </div>

                    <div class="employee-form-grid employee-form-grid--two-cols mt-4">
                        <div class="employee-form-group">
                            <label>Telepon</label>
                            <input type="tel" name="telepon" value="{{ old('telepon', $employee->telepon ?? '') }}" required pattern="^(\+62|0)[0-9]{7,12}$" title="Nomor telepon harus diawali +62 atau 0 dan 8-13 angka" />
                        </div>
                        <div class="employee-form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $birthDate) }}">
                        </div>
                    </div>

                    <div class="employee-form-group mt-4">
                        <label>NIK @if(!$isOwner)<span class="text-sm text-gray-500">(diisi oleh owner)</span>@endif</label>
                        <input type="text" name="nik" inputmode="numeric" maxlength="16" value="{{ old('nik', $employee->nik ?? '') }}" required pattern="^[0-9]{16}$" title="NIK harus berisi 16 angka" @if(!$isOwner) readonly @endif />
                    </div>

                    <div class="employee-divider"></div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Keamanan Akun</h3>
                    <p class="employee-form-note">Masukkan password saat ini untuk menyimpan perubahan apa pun.</p>

                    <div class="employee-form-group mt-4">
                        <label>Password Saat Ini <span class="text-red-600">*</span></label>
                        <input type="password" name="current_password" required>
                    </div>

                    <div class="employee-form-grid employee-form-grid--two-cols mt-4">
                        <div class="employee-form-group">
                            <label>Password Baru</label>
                            <input type="password" name="new_password">
                        </div>
                        <div class="employee-form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation">
                        </div>
                    </div>

                    <div class="employee-divider"></div>

                    <div class="employee-actions">
                        <button type="submit" class="employee-btn employee-btn--primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('employee.dashboard') }}" class="employee-btn employee-btn--ghost">
                            <i class="fas fa-arrow-left"></i>
                            Batal
                        </a>
                    </div>
                </form>

                <div class="employee-divider"></div>

                <form method="POST" action="{{ route('employee.logout') }}">
                    @csrf
                    <button type="submit" class="employee-btn employee-btn--danger w-full justify-center">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </article>
        </div>

    @else
        <article class="employee-card text-center text-gray-600">
            Pegawai tidak ditemukan.
        </article>
    @endif
</div>

@push('scripts')
<script>
    const handleEmployeeFotoUpload = (input) => {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        if (file.size > 5 * 1024 * 1024) { alert('Ukuran file terlalu besar (max 5MB).'); return; }
        const allowed = ['image/jpeg','image/png','image/jpg','image/gif'];
        if (!allowed.includes(file.type)) { alert('Tipe file tidak didukung.'); return; }

        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.querySelector('.employee-avatar');
            if (preview) {
                preview.innerHTML = '';
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            }
        };
        reader.readAsDataURL(file);

        const form = new FormData();
        form.append('foto_profil', file);
        form.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch('{{ route("employee.profile.foto.upload") }}', { method: 'POST', body: form })
            .then(r => r.json())
            .then(data => {
                if (data.success) { alert(data.message || 'Foto diperbarui'); }
                else alert(data.message || 'Gagal mengupload foto');
            }).catch(() => alert('Gagal mengupload foto'));
    };

    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('ubah-foto-btn');
        const input = document.getElementById('foto_profil_input');
        if (btn && input) {
            btn.addEventListener('click', (e) => { e.preventDefault(); input.click(); });
            input.addEventListener('change', () => handleEmployeeFotoUpload(input));
        }

        // Client-side form validation using HTML5 constraint API + inline name error
        const profileForm = document.getElementById('employee-profile-form');
        const nameInput = document.getElementById('employee-name');
        const nameError = document.getElementById('name-error');

        const nameRegex = /^[\p{L}\s\.\-']+$/u;

        if (nameInput) {
            nameInput.addEventListener('input', () => {
                if (nameInput.value.trim() === '') {
                    nameError.textContent = '';
                    return;
                }
                try {
                    if (!nameRegex.test(nameInput.value)) {
                        nameError.textContent = 'Nama hanya boleh berisi huruf, spasi, titik, tanda hubung, atau kutip tunggal.';
                    } else {
                        nameError.textContent = '';
                    }
                } catch (err) {
                    // Fallback: if browser doesn't support unicode property escapes, use simpler check
                    const fallback = /^[A-Za-z\s\.\-']+$/;
                    if (!fallback.test(nameInput.value)) {
                        nameError.textContent = 'Nama hanya boleh berisi huruf, spasi, titik, tanda hubung, atau kutip tunggal.';
                    } else {
                        nameError.textContent = '';
                    }
                }
            });
        }

        if (profileForm) {
            profileForm.addEventListener('submit', (e) => {
                // Let browser handle built-in constraints first
                if (!profileForm.checkValidity()) {
                    e.preventDefault();
                    profileForm.reportValidity();
                    return false;
                }

                // Additional inline validation for name
                if (nameInput) {
                    let valid = true;
                    try { valid = nameRegex.test(nameInput.value); } catch (err) { valid = (/^[A-Za-z\s\.\-']+$/).test(nameInput.value); }
                    if (!valid) {
                        e.preventDefault();
                        nameError.textContent = 'Nama hanya boleh berisi huruf, spasi, titik, tanda hubung, atau kutip tunggal.';
                        nameInput.focus();
                        return false;
                    }
                }

                return true;
            });
        }
    });
</script>
@endpush

@endsection
