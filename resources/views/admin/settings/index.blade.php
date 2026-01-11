@extends('layouts.app')

@section('title', 'Pengaturan Sistem - Admin')

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
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-white rounded-2xl p-8 mb-6 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
            <div class="flex flex-col items-center justify-center gap-3">
                <h1 class="text-5xl font-bold" style="color: #a3e635;">⚙️ Pengaturan Sistem</h1>
                <p class="text-white/90 text-base">Kelola konfigurasi dan preferensi aplikasi</p>
            </div>
        </div>
    </div>

<div class="max-w-6xl mx-auto px-4">
    <!-- System Actions (reduced) -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Aksi Sistem</h2>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            <form action="{{ route('admin.settings.toggleMaintenance') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600 flex items-center justify-center">
                    <i class="fas fa-tools mr-2"></i>
                    {{ app()->isDownForMaintenance() ? 'Nonaktifkan Maintenance' : 'Aktifkan Maintenance' }}
                </button>
            </form>
        </div>
    </div>

    {{-- General Settings removed per request --}}

    <!-- Notification Settings (checkboxes removed; keep threshold) -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Pengaturan Notifikasi</h2>
        <form action="{{ route('admin.settings.updateNotifications') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Peringatan Stok</label>
                    <input type="number" name="alert_threshold" value="{{ $settings['alert_threshold'] ?? 5 }}" min="1" max="100" 
                           class="w-32 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-gray-500 ml-2">item</span>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i>Simpan Batas Peringatan Stok
                </button>
            </div>
        </form>
    </div>

    <!-- Payment Verification Settings -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4"><i class="fas fa-credit-card mr-2"></i>Pengaturan Verifikasi Pembayaran</h2>
        <form action="{{ route('admin.settings.updatePaymentVerification') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-3">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Aktifkan verifikasi pembayaran untuk meninjau bukti transfer sebelum memproses pesanan.
                    </p>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="auto_verify_cod" id="auto_verify_cod" value="1" 
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                           {{ ($settings['auto_verify_cod'] ?? true) ? 'checked' : '' }}>
                    <label for="auto_verify_cod" class="ml-3 text-gray-700">
                        <span class="font-semibold">Auto-Verifikasi COD</span>
                        <p class="text-sm text-gray-600 mt-1">Pesanan COD (tunai) otomatis terverifikasi tanpa perlu manual check</p>
                    </label>
                </div>

                <div class="pt-2 border-t">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pesan untuk Admin saat ada Order Baru</label>
                    <textarea name="new_order_message" placeholder="Contoh: Periksa bukti pembayaran di dashboard admin..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              rows="3">{{ $settings['new_order_message'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection