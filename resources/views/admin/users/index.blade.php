@extends('layouts.app')

@section('title', 'Kelola User - ' . ucfirst(auth()->user()->role))

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
    
    .admin-header {
        background: linear-gradient(135deg, #2d5a3d 0%, #1e3e2a 100%);
    }
    
    .stat-card {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .section-card {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .action-btn {
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    .admin-container {
        max-width: 100%;
        width: 100%;
        overflow-x: hidden;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .main-content {
        margin-left: 0 !important;
    }
</style>

<div class="w-full py-6" style="margin: 0 !important; padding: 0 1rem 0 0 !important;">
    <!-- Header -->
    <div class="text-white rounded-2xl p-8 mb-6 border-2 text-center" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-col items-center justify-center gap-3">
            <h1 class="text-5xl font-bold" style="color: #a3e635;">👥 Kelola User</h1>
            <p class="text-white/90 text-base">Lihat dan kendalikan akun pengguna, cek poin, serta kurangi poin untuk penukaran.</p>
        </div>
    </div>

    <!-- Search / Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 mb-2 text-center">Cari User</label>
            <div class="flex justify-center">
                <div class="w-full max-w-5xl flex gap-3 items-center">
                    <input type="text" name="q" value="{{ request('q', '') }}" 
                           placeholder="Nama atau email..." 
                           class="flex-1 px-6 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg">

                    <button type="submit" class="px-6 py-3 text-white rounded-lg hover:opacity-90 transition font-medium" style="background: #a3e635; color: #1e3e2a;">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Daftar User</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                @foreach($users as $user)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <div class="flex items-center px-4 py-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            <p class="text-xs text-gray-500 mt-1">Role: <strong>{{ $user->role }}</strong></p>
                        </div>

                        <div class="text-right mr-6">
                            <p class="text-xl font-bold text-gray-900">{{ number_format($user->points ?? 0) }}</p>
                            <p class="text-xs text-gray-500">Points</p>
                        </div>

                        <div class="flex-shrink-0">
                            <form method="post" action="{{ route('admin.points.deduct') }}" class="w-full">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="flex gap-2 items-center">
                                    <input name="points" type="number" min="1" placeholder="Jumlah" class="w-24 px-3 py-2 border border-gray-300 rounded-lg" required>
                                    <input name="reason" type="text" placeholder="Alasan" class="w-48 px-3 py-2 border border-gray-300 rounded-lg" required>
                                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Kurangi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($users, 'links'))
                <div class="mt-6 flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
                    @if ($users->onFirstPage())
                        <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed flex items-center">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 text-white rounded hover:opacity-90 transition flex items-center" style="background: #a3e635; color: #1e3e2a;">Previous</a>
                    @endif

                    <div class="text-gray-600">
                        <span class="font-semibold">Page {{ $users->currentPage() }}</span>
                        <span class="mx-2">of</span>
                        <span class="font-semibold">{{ $users->lastPage() }}</span>
                        <span class="ml-4 text-sm text-gray-500">(Total {{ $users->total() }} user)</span>
                    </div>

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 text-white rounded hover:opacity-90 transition flex items-center" style="background: #a3e635; color: #1e3e2a;">Next</a>
                    @else
                        <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed flex items-center">Next</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
