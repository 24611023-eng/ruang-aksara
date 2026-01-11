@extends('layouts.app')

@section('title', 'Dashboard - Ruang Aksara')

@section('content')
<style>
    .home-page-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2.5rem 2rem;
        background: linear-gradient(135deg, rgba(45, 90, 61, 0.15) 0%, rgba(30, 62, 42, 0.1) 100%);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(163, 230, 53, 0.2);
    }
    
    .home-page-header h1 {
        font-size: 2.25rem;
        font-weight: 800;
        color: #a3e635;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        letter-spacing: -0.5px;
    }
    
    .home-page-header h1 i {
        color: #a3e635;
    }
    
    .home-page-header p {
        font-size: 1.05rem;
        color: #ffffff;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
        font-weight: 500;
    }
</style>

<div class="max-w-7xl mx-auto px-4">
    <div class="home-page-header">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <p>Kelola toko buku dan monitor penjualan Anda</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Statistik cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Total Buku</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalBooks ?? 0 }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Total Pesanan</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalOrders ?? 0 }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Pesanan Aktif</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $activeOrders ?? 0 }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Total User</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers ?? 0 }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Buku Terbaru -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Buku Terbaru</h2>
            <div class="space-y-3">
                @if(isset($recentBooks) && $recentBooks->count())
                    @foreach($recentBooks as $book)
                    <div class="flex items-center justify-between py-2 border-b">
                        <div>
                            <p class="font-medium">{{ $book->judul }}</p>
                            <p class="text-sm text-gray-600">{{ $book->penulis }}</p>
                        </div>
                        <span class="text-green-600 font-semibold">Rp {{ number_format($book->harga, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada buku terbaru.</p>
                @endif
            </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Pesanan Terbaru</h2>
            <div class="space-y-3">
                @if(isset($recentOrders) && $recentOrders->count())
                    @foreach($recentOrders as $order)
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-medium">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">{{ $order->book->judul ?? 'Buku tidak tersedia' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($order->payment_method != 'cash')
                                <span class="px-2 py-1 text-xs rounded {{ ($order->payment_status ?? 'pending') == 'verified' ? 'bg-green-100 text-green-800' : (($order->payment_status ?? 'pending') == 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">{{ ucfirst($order->payment_status ?? 'pending') }}</span>
                            @endif
                            <span class="px-2 py-1 text-xs rounded {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada pesanan terbaru.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
        <div class="flex space-x-4">
            {{-- ✅ PERBAIKAN: ganti route('user.profile') jadi route('profile') --}}
            <a href="{{ route('profile') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Edit Profil
            </a>
            <a href="{{ route('books.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Lihat Buku
            </a>
            <a href="{{ route('orders.index') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                Lihat Pesanan
            </a>
        </div>
    </div>
</div>
@endsection