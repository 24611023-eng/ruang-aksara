@extends('layouts.app')

@section('title', 'Kelola Stok Peminjaman - ' . ucfirst(auth()->user()->role))

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
    <!-- Header with Button -->
    <div class="text-white rounded-2xl p-8 mb-6 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-row gap-8 items-center">
            <!-- Title Section -->
            <div class="flex-1">
                <h1 class="text-5xl font-bold" style="color: #a3e635;">📚 Kelola Stok Peminjaman</h1>
                <p class="text-white/90 text-base mt-2">Atur stok buku yang tersedia untuk peminjaman perpustakaan</p>
            </div>
            <!-- Button Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('admin.loan-stock.create') }}" class="inline-block text-white px-6 py-3 rounded-lg transition font-medium" style="background: #a3e635; color: #1e3e2a;">
                    <i class="fas fa-plus mr-2"></i>Tambah Buku Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
            <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.loan-stock.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                    <input type="text" name="search" value="{{ request('search', '') }}" 
                           placeholder="Judul atau penulis..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok (Terendah)</option>
                        <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok (Tertinggi)</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2 justify-between">
                <button type="submit" class="px-6 py-2 text-white rounded-lg hover:opacity-90 transition font-medium" style="background: #a3e635; color: #1e3e2a;">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <a href="{{ route('admin.loan-stock.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Books Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-green-600 to-green-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Cover</th>
                        <th class="px-6 py-4 text-left font-semibold">Judul Buku</th>
                        <th class="px-6 py-4 text-left font-semibold">Penulis</th>
                        <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-4 text-center font-semibold">Stok Peminjaman</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <img src="{{ $book->image_url ?? asset('images/default-book.jpg') }}" alt="{{ $book->judul }}" class="h-16 w-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">
                                    <a href="{{ route('admin.loan-stock.edit', $book->id) }}" class="text-blue-600 hover:underline">
                                        {{ $book->judul }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">ID: {{ $book->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $book->penulis ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $book->kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <input type="number" 
                                           class="stock-input w-20 px-3 py-2 border border-gray-300 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-green-500" 
                                           value="{{ $book->loan_stok ?? 0 }}" 
                                           min="0" 
                                           max="9999"
                                           data-book-id="{{ $book->id }}"
                                           data-original="{{ $book->loan_stok ?? 0 }}">
                                    @if($book->loan_stok === 0 || $book->loan_stok === null)
                                        <span class="text-red-500 text-sm font-semibold">
                                            <i class="fas fa-exclamation-circle"></i> Habis
                                        </span>
                                    @elseif(($book->loan_stok ?? 0) <= ($alertThreshold ?? 5))
                                        <span class="text-orange-500 text-sm font-semibold">
                                            <i class="fas fa-exclamation-triangle"></i> Rendah
                                        </span>
                                    @else
                                        <span class="text-green-500 text-sm font-semibold">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" 
                                            class="save-stock-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed" 
                                            data-book-id="{{ $book->id }}"
                                            disabled>
                                        <i class="fas fa-save mr-1"></i>Simpan
                                    </button>
                                    <button type="button" 
                                            class="history-btn px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                            data-book-id="{{ $book->id }}">
                                        <i class="fas fa-history mr-1"></i>Riwayat
                                    </button>
                                    <button type="button"
                                            class="delete-book-btn px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                            data-book-id="{{ $book->id }}">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-600 text-lg">Tidak ada buku yang ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t">
            {{ $books->links() }}
        </div>
    </div>
</div>

<!-- History Modal -->
<div id="historyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Riwayat Perubahan Stok</h2>
            <button onclick="closeHistoryModal()" class="text-white hover:text-gray-200">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="historyContent" class="p-6">
            <!-- History will be loaded here -->
        </div>
    </div>
</div>

<script>
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    // Enable/disable save button on input change
    document.querySelectorAll('.stock-input').forEach(input => {
        input.addEventListener('change', function() {
            const saveBtn = this.closest('tr').querySelector('.save-stock-btn');
            const originalValue = this.dataset.original;
            if (this.value !== originalValue) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        });
    });

    // Save stock button click handler
    document.querySelectorAll('.save-stock-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.bookId;
            const input = this.closest('tr').querySelector('.stock-input');
            const newStock = parseInt(input.value);

            if (isNaN(newStock) || newStock < 0) {
                alert('Masukkan nilai stok yang valid');
                return;
            }

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Menyimpan...';

            try {
                const response = await fetch(`/admin/loan-stock/${bookId}`, {
                    method: 'PUT',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ loan_stok: newStock })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Stok berhasil diperbarui');
                    input.dataset.original = newStock;
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-save mr-1"></i>Simpan';
                    // Refresh page to update status badges
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert('Gagal: ' + data.message);
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-save mr-1"></i>Simpan';
                }
            } catch (error) {
                console.error(error);
                alert('Gagal memperbarui stok');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-save mr-1"></i>Simpan';
            }
        });
    });

    // History button click handler
    document.querySelectorAll('.history-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.bookId;
            const bookName = this.closest('tr').querySelector('td').textContent;

            try {
                const response = await fetch(`/admin/loan-stock/${bookId}/history`);
                const data = await response.json();
                let historyHtml = `
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">${data.book.judul}</h3>
                        <p class="text-gray-600">Stok saat ini: <strong>${data.book.loan_stok || 0}</strong></p>
                    </div>
                    <div class="space-y-3">
                `;

                if (data.history.length === 0) {
                    historyHtml += '<p class="text-gray-500 text-center py-4">Belum ada riwayat perubahan</p>';
                } else {
                    data.history.forEach(item => {
                        const changeColor = item.change > 0 ? 'text-green-600' : 'text-red-600';
                        const changeIcon = item.change > 0 ? '↑' : '↓';
                        const createdAt = new Date(item.created_at).toLocaleString('id-ID');
                        
                        historyHtml += `
                            <div class="border-l-4 border-gray-300 pl-4 py-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-800">
                                        ${item.type === 'loan' ? '📚 Peminjaman' : '🔄 Penyesuaian'}
                                    </span>
                                    <span class="text-xs text-gray-500">${createdAt}</span>
                                </div>
                                <div class="mt-1 text-sm text-gray-700">
                                    ${item.previous_stock} → ${item.new_stock}
                                    <span class="${changeColor} font-bold ml-2">${changeIcon} ${item.change}</span>
                                </div>
                            </div>
                        `;
                    });
                }

                historyHtml += '</div>';
                document.getElementById('historyContent').innerHTML = historyHtml;
                document.getElementById('historyModal').classList.remove('hidden');
            } catch (error) {
                console.error(error);
                alert('Gagal memuat riwayat');
            }
        });
    });

    function closeHistoryModal() {
        document.getElementById('historyModal').classList.add('hidden');
    }

    // Delete book handler (attach on page load)
    document.querySelectorAll('.delete-book-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.bookId;
            if (!confirm('Yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')) return;

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Menghapus...';

            try {
                const response = await fetch(`/admin/loan-stock/${bookId}`, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    const text = await response.text();
                    throw new Error('Server error: ' + (text || response.status));
                }

                const data = await response.json();
                if (data.success) {
                    alert('Buku berhasil dihapus');
                    // remove the row
                    const row = this.closest('tr');
                    row.parentNode.removeChild(row);
                } else {
                    alert('Gagal menghapus: ' + (data.message || 'Unknown'));
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-trash mr-1"></i>Hapus';
                }
            } catch (error) {
                console.error(error);
                alert('Gagal menghapus buku');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-trash mr-1"></i>Hapus';
            }
        });
    });
</script>
@endsection
