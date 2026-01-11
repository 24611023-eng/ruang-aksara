@extends('layouts.app')

@section('title', 'Profil - Ruang Aksara Admin')

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

    .avatar-container {
        position: relative;
        display: inline-block;
    }

    .avatar-container:hover .avatar-overlay {
        display: flex;
    }

    .avatar-overlay {
        display: none;
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 9999px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .avatar-image {
        width: 200px;
        height: 200px;
        border-radius: 9999px;
        object-fit: cover;
        border: 4px solid #10b981;
    }

    .avatar-placeholder {
        width: 200px;
        height: 200px;
        border-radius: 9999px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #10b981;
        color: white;
        font-size: 60px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 32px;
    }
</style>

<div class="w-full py-6" style="margin: 0 !important; padding: 0 1rem 0 0 !important;">
    <!-- Header -->
    <div class="text-white rounded-2xl p-8 mb-6 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-row gap-8 items-center">
            <!-- Title Section -->
            <div class="flex-1">
                <h1 class="text-5xl font-bold" style="color: #a3e635;">👤 Profil {{ Auth::user()->role === 'owner' ? 'Owner' : 'Admin' }}</h1>
                <p class="text-white/90 text-base mt-2">Kelola informasi akun dan keamanan Anda</p>
            </div>
            <!-- Button Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="inline-block text-white px-6 py-3 rounded-lg transition font-medium" style="background: #a3e635; color: #1e3e2a;">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

<div class="max-w-2xl mx-auto px-4">
    <!-- Main Card -->
    <div class="card animate-fade-in">
        <!-- User Info Header -->
        <div class="text-center mb-12">
            <div class="mb-6">
                <div class="avatar-container mx-auto">
                    <div id="avatarDisplay" class="relative">
                        @php
                            $user = Auth::user();
                            $hasPhoto = !empty($user->foto_profil);
                            $storageBase = asset('storage');
                            if ($hasPhoto) {
                                $storagePath = 'storage/' . $user->foto_profil;
                                $publicFull = public_path($storagePath);
                                $version = file_exists($publicFull) ? filemtime($publicFull) : time();
                                $imgUrl = asset($storagePath) . '?v=' . $version;
                            }
                        @endphp

                        @if($hasPhoto)
                            <img id="avatarImage" src="{{ $imgUrl }}" alt="{{ $user->name }}" class="avatar-image">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="avatar-overlay">
                        <div class="text-center">
                            <i class="fas fa-camera text-white text-4xl mb-2"></i>
                            <p class="text-white text-sm font-semibold">Ubah Foto</p>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h2>
            <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
            <div class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                @if(Auth::user()->role === 'owner')
                    <i class="fas fa-crown text-yellow-500 mr-1"></i>Owner
                @else
                    <i class="fas fa-shield-alt mr-1"></i>Admin
                @endif
            </div>
        </div>

        <!-- Status Messages -->
        @if(session('success'))
            <div id="successMsg" class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center animate-fade-in">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="errorMsg" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center animate-fade-in">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div id="errorMsg" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg animate-fade-in">
                <p class="font-semibold mb-2 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Terjadi kesalahan:
                </p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Upload Section -->
        <div class="bg-gray-50 rounded-lg p-12 text-center border-2 border-dashed border-gray-300 hover:border-green-500 transition cursor-pointer" id="dropZone">
            <input type="file" id="fotoInput" accept="image/*" class="hidden">
            
            <div class="py-8">
                <i class="fas fa-cloud-upload-alt text-7xl text-green-600 mb-6 block"></i>
                <h3 class="text-2xl font-semibold text-gray-800 mb-3">
                    Klik atau drag foto di sini
                </h3>
                <p class="text-gray-600 text-base mb-2">
                    Format: JPG, PNG, GIF (Max 5MB)
                </p>
            </div>
        </div>

        <!-- Loading & Upload Button -->
        <div class="mt-6 flex gap-3">
            <button id="uploadBtn" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center" disabled>
                <i class="fas fa-upload mr-2"></i>
                Upload Foto
            </button>
            <button type="button" onclick="window.history.back()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition">
                <i class="fas fa-times mr-2"></i>
                Batal
            </button>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden mt-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg flex items-center">
            <div class="spinner animate-spin">
                <i class="fas fa-spinner mr-2"></i>
            </div>
            <span>Sedang upload foto...</span>
        </div>
    </div>

    <!-- Info Section -->
    <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg text-blue-800">
        <h3 class="font-semibold mb-3 flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            Informasi
        </h3>
        <ul class="space-y-2 text-sm">
            <li>✓ Hanya foto profil yang bisa diubah di halaman ini</li>
            <li>✓ Data akun lainnya (nama, email, dll) tidak akan berubah</li>
            <li>✓ Ukuran file maksimal: 5 MB</li>
            <li>✓ Format yang didukung: JPG, PNG, GIF</li>
        </ul>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fotoInput = document.getElementById('fotoInput');
        const uploadBtn = document.getElementById('uploadBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');
        let selectedFile = null;

        // Click to select file
        if (dropZone && fotoInput) {
            dropZone.addEventListener('click', () => {
                console.log('Dropzone clicked');
                fotoInput.click();
            });

            // Drag and drop
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('border-green-500', 'bg-green-50');
                console.log('Drag over');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('border-green-500', 'bg-green-50');
                console.log('Drag leave');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('border-green-500', 'bg-green-50');
                
                const files = e.dataTransfer.files;
                console.log('Files dropped:', files.length);
                if (files.length > 0) {
                    const file = files[0];
                    handleFileSelect(file);
                }
            });

            // File input change
            fotoInput.addEventListener('change', (e) => {
                console.log('File input changed');
                if (e.target.files.length > 0) {
                    handleFileSelect(e.target.files[0]);
                }
            });
        }

        function handleFileSelect(file) {
            console.log('Handling file:', file.name, file.type, file.size);
            
            // Validate file
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!validTypes.includes(file.type)) {
                showError('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                return;
            }

            if (file.size > maxSize) {
                showError('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }

            selectedFile = file;
            uploadBtn.disabled = false;
            console.log('File selected, upload button enabled');

            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                const avatarDisplay = document.getElementById('avatarDisplay');
                if (avatarDisplay) {
                    avatarDisplay.innerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-image">`;
                    console.log('Preview updated');
                }
            };
            reader.readAsDataURL(file);
        }

        // Upload button click
        if (uploadBtn) {
            uploadBtn.addEventListener('click', async () => {
                if (!selectedFile) {
                    showError('Pilih file terlebih dahulu');
                    return;
                }

                console.log('Uploading file:', selectedFile.name);

                const formData = new FormData();
                formData.append('foto_profil', selectedFile);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                uploadBtn.disabled = true;
                loadingIndicator.classList.remove('hidden');

                try {
                    console.log('Sending upload request');
                    const response = await fetch('{{ route("profile.foto.upload") }}', {
                        method: 'POST',
                        body: formData
                    });

                    console.log('Response status:', response.status);
                    const data = await response.json();
                    console.log('Response data:', data);

                    if (data.success) {
                        showSuccess('Foto profil berhasil diperbarui!');

                        // Try to update the avatar immediately using response data (path or url)
                        const avatarDisplay = document.getElementById('avatarDisplay');
                        const storageBase = '{{ asset('storage') }}';
                        let newUrl = null;
                        if (data.url) {
                            newUrl = data.url + '?v=' + Date.now();
                        } else if (data.path) {
                            newUrl = storageBase + '/' + data.path + '?v=' + Date.now();
                        }

                        if (newUrl && avatarDisplay) {
                            avatarDisplay.innerHTML = `<img id="avatarImage" src="${newUrl}" alt="Avatar" class="avatar-image">`;
                        } else {
                            // Fallback: reload page to pick up server-side changes
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        }
                    } else {
                        showError('Gagal upload foto: ' + (data.message || 'Error unknown'));
                        uploadBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    showError('Terjadi kesalahan: ' + error.message);
                    uploadBtn.disabled = false;
                } finally {
                    loadingIndicator.classList.add('hidden');
                }
            });
        }

        function showSuccess(message) {
            const msg = document.createElement('div');
            msg.className = 'fixed top-4 right-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center animate-fade-in z-50';
            msg.innerHTML = `
                <i class="fas fa-check-circle mr-3"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            document.body.appendChild(msg);
            setTimeout(() => msg.remove(), 5000);
        }

        function showError(message) {
            const msg = document.createElement('div');
            msg.className = 'fixed top-4 right-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center animate-fade-in z-50';
            msg.innerHTML = `
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            document.body.appendChild(msg);
            setTimeout(() => msg.remove(), 5000);
        }
    });
</script>
@endsection
