@extends('layouts.app')

@section('title', 'Tambah Buku Baru - Admin')

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

    .form-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 1.75rem;
        border: 1px solid rgba(163, 230, 53, 0.25);
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.15);
        padding: 2.5rem;
    }

    .form-card label {
        color: #1f2937;
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    .form-card input:not([type="file"]),
    .form-card select,
    .form-card textarea {
        border-radius: 0.9rem;
        border: 1.5px solid rgba(148, 163, 184, 0.45);
        background: #f8fafc;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-card input:focus,
    .form-card select:focus,
    .form-card textarea:focus {
        border-color: #a3e635;
        box-shadow: 0 0 0 3px rgba(163, 230, 53, 0.25);
        background: #ffffff;
    }

    .form-helper {
        font-size: 0.75rem;
        color: #64748b;
    }

    .pill-label {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1f2937;
        background: rgba(163, 230, 53, 0.18);
        border: 1px solid rgba(163, 230, 53, 0.35);
    }

    .action-primary {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border: none;
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.35);
    }

    .action-primary:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
    }

    .action-secondary {
        border: 2px solid rgba(148, 163, 184, 0.6);
        background: white;
        color: #475569;
    }

    .action-secondary:hover {
        border-color: rgba(148, 163, 184, 0.9);
    }
</style>

<div class="w-full py-6" style="margin: 0 !important; padding: 0 1rem 0 0 !important;">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="text-white rounded-2xl p-8 border-2" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-5">
                <div class="flex-1">
                    <p class="pill-label text-white/90" style="background: rgba(163,230,53,0.25); border-color: rgba(163,230,53,0.4);">
                        <i class="fas fa-book"></i> Modul Inventori Perpustakaan
                    </p>
                    <h1 class="text-5xl font-extrabold mt-3" style="color: #a3e635;">Tambah Buku Baru</h1>
                    <p class="text-white/80 mt-2">Lengkapi detail buku fisik maupun digital untuk menjaga katalog tetap rapi.</p>
                </div>
                <div class="bg-white/15 border border-white/30 rounded-2xl px-6 py-4 text-sm leading-relaxed">
                    <p class="text-white font-semibold">Checklist singkat:</p>
                    <ul class="text-white/80 space-y-1 mt-2">
                        <li>• Pastikan stok awal sesuai gudang</li>
                        <li>• Isi margin sesuai kategori buku</li>
                        <li>• Masukkan cover beresolusi 600px</li>
                    </ul>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="p-5 rounded-2xl border border-red-200 bg-red-50/90 text-red-700">
                <div class="flex gap-3">
                    <span class="text-red-500 text-2xl"><i class="fas fa-exclamation-circle"></i></span>
                    <div>
                        <p class="font-semibold">Periksa kembali data yang diisi:</p>
                        <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="judul" class="block text-sm">Judul Buku *</label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="penulis" class="block text-sm">Penulis *</label>
                        <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" required class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm">Kategori *</label>
                        <div class="flex gap-3 mt-2">
                            <select name="kategori" id="kategori" required class="flex-1 px-4 py-3">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategories as $kategori)
                                    <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openCategoryModalBooks()" class="px-5 py-3 rounded-xl text-white font-semibold shadow-md" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                <i class="fas fa-plus mr-1"></i>Baru
                            </button>
                        </div>
                        <p class="form-helper mt-1">Tambah kategori khusus jika tidak tersedia.</p>
                    </div>

                    <div>
                        <label for="penerbit" class="block text-sm">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" class="mt-2 w-full px-4 py-3">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="harga" class="block text-sm">Harga Jual (Rp)</label>
                        <input type="number" name="harga" id="harga" min="0" step="1" class="mt-2 w-full px-4 py-3">
                        <p class="form-helper mt-1">Biarkan kosong jika ingin dihitung otomatis.</p>
                    </div>

                    <div>
                        <label for="purchase_price" class="block text-sm">Harga Beli (Rp)</label>
                        <input type="number" name="purchase_price" id="purchase_price" min="0" step="1" class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="profit_margin_percent" class="block text-sm">Margin Keuntungan (%) *</label>
                        <div class="flex gap-3">
                            <input type="number" name="profit_margin_percent" id="profit_margin_percent" value="{{ old('profit_margin_percent', 35) }}" required min="0" max="100" step="1" class="mt-2 flex-1 px-4 py-3">
                            <button type="button" onclick="autoCalculateSellingPrice()" class="mt-2 px-5 py-3 rounded-xl text-white font-semibold shadow-md" style="background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);">
                                <i class="fas fa-calculator mr-1"></i>Hitung
                            </button>
                        </div>
                        <p class="form-helper mt-1">Novel/Fiksi: 35%, Referensi: 25%, Non-Fiksi: 30%</p>
                    </div>

                    <div>
                        <label for="stok" class="block text-sm">Stok *</label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok') }}" required min="0" class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="berat" class="block text-sm">Berat (gram) *</label>
                        <input type="number" name="berat" id="berat" value="{{ old('berat', 500) }}" required min="1" step="1" class="mt-2 w-full px-4 py-3">
                        <p class="form-helper mt-1">Digunakan untuk perhitungan ongkir otomatis.</p>
                    </div>

                    <div>
                        <label for="halaman" class="block text-sm">Jumlah Halaman *</label>
                        <input type="number" name="halaman" id="halaman" value="{{ old('halaman') }}" required min="1" class="mt-2 w-full px-4 py-3">
                    </div>

                    <div>
                        <label for="status" class="block text-sm">Status *</label>
                        <select name="status" id="status" required class="mt-2 w-full px-4 py-3">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>

                    <div>
                        <label for="image" class="block text-sm">Cover Buku</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-2 w-full px-4 py-3 border rounded-xl">
                        <p class="form-helper mt-2">Format: JPEG/PNG/GIF • Maks 2MB • Rasio ideal 2:3</p>
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="preview" class="h-36 w-28 object-cover rounded-xl border border-dashed border-gray-300">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm">Deskripsi *</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required class="mt-2 w-full px-4 py-3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex flex-wrap gap-4">
                <button type="submit" class="action-primary text-white px-8 py-3 rounded-2xl font-semibold inline-flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Buku
                </button>
                <button type="button" onclick="handleBatal()" class="action-secondary px-8 py-3 rounded-2xl font-semibold inline-flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Auto-calculate Harga Jual (Selling Price) dari Harga Beli + Margin
    function autoCalculateSellingPrice() {
        const hargaBeli = parseFloat(document.getElementById('purchase_price').value) || 0;
        const marginPercent = parseFloat(document.getElementById('profit_margin_percent').value) || 35;

        if (hargaBeli <= 0) {
            alert('Masukkan Harga Beli terlebih dahulu');
            document.getElementById('purchase_price').focus();
            return;
        }

        // Formula: Harga Jual = Harga Beli ÷ (1 - Margin%)
        const margin = marginPercent / 100;
        const hargaJual = Math.round(hargaBeli / (1 - margin));

        document.getElementById('harga').value = hargaJual;
        
        // Show confirmation
        const margin_input = marginPercent.toFixed(0);
        const keuntungan = hargaJual - hargaBeli;
        alert(`✅ Harga Jual dihitung otomatis:\n\nHarga Beli: Rp ${hargaBeli.toLocaleString('id-ID')}\nMargin: ${margin_input}%\nKeuntungan: Rp ${keuntungan.toLocaleString('id-ID')}\n\nHarga Jual: Rp ${hargaJual.toLocaleString('id-ID')}`);
    }

    // Validasi margin ketika berubah
    document.addEventListener('DOMContentLoaded', function() {
        const profitMarginInput = document.getElementById('profit_margin_percent');
        if (profitMarginInput) {
            profitMarginInput.addEventListener('change', function() {
                const margin = parseFloat(this.value) || 35;
                if (margin < 20 || margin > 50) {
                    console.warn('⚠️ Warning: Margin normal untuk buku adalah 20-50%');
                }
            });
        }
    });

    // Preview Image Function
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    // SIMPAN REFERRER SAAT PAGE LOAD
    document.addEventListener('DOMContentLoaded', function() {
        // Simpan URL sebelumnya ke sessionStorage
        if (document.referrer && !document.referrer.includes('/admin/books/create')) {
            sessionStorage.setItem('previousUrl', document.referrer);
        }
    });

    // FUNGSI TOMBOL BATAL YANG SUPER EFFECTIVE
    function handleBatal() {
        const previousUrl = sessionStorage.getItem('previousUrl');
        const currentUrl = window.location.href;
        
        console.log('Previous URL:', previousUrl);
        console.log('Current URL:', currentUrl);
        console.log('History length:', window.history.length);
        
        // Prioritaskan URL yang disimpan di sessionStorage
        if (previousUrl && previousUrl !== currentUrl && !previousUrl.includes('/admin/books/create')) {
            window.location.href = previousUrl;
        } 
        // Jika tidak ada URL yang disimpan, coba history back
        else if (window.history.length > 2) {
            window.history.go(-1);
        }
        // Fallback ke halaman kelola buku
        else {
            window.location.href = "{{ route('admin.books.index') }}";
        }
    }

    // Category Modal Functions
    function openCategoryModalBooks() {
        const modal = document.getElementById('categoryModalBooks');
        if (!modal) {
            // Create modal if it doesn't exist
            const modalHtml = `
                <div id="categoryModalBooks" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg max-w-md w-full">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 flex justify-between items-center">
                            <h2 class="text-xl font-bold">Tambah Kategori Baru</h2>
                            <button type="button" onclick="closeCategoryModalBooks()" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                                <input type="text" id="newCategoryInputBooks" placeholder="Masukkan nama kategori baru"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-2">Kategori akan ditambahkan ke daftar dan dipilih otomatis</p>
                            </div>
                            <div class="flex gap-2 justify-end pt-4 border-t">
                                <button type="button" onclick="closeCategoryModalBooks()" class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400">
                                    Batal
                                </button>
                                <button type="button" onclick="addNewCategoryBooks()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    <i class="fas fa-plus mr-1"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
        document.getElementById('categoryModalBooks').classList.remove('hidden');
        document.getElementById('newCategoryInputBooks').focus();
    }

    function closeCategoryModalBooks() {
        const modal = document.getElementById('categoryModalBooks');
        if (modal) {
            modal.classList.add('hidden');
            document.getElementById('newCategoryInputBooks').value = '';
        }
    }

    function addNewCategoryBooks() {
        const input = document.getElementById('newCategoryInputBooks');
        const categoryName = input.value.trim();

        if (!categoryName) {
            alert('Masukkan nama kategori terlebih dahulu');
            return;
        }

        const select = document.getElementById('kategori');
        
        // Check if category already exists
        let exists = false;
        for (let option of select.options) {
            if (option.value === categoryName) {
                exists = true;
                break;
            }
        }

        if (exists) {
            alert('Kategori "' + categoryName + '" sudah ada dalam daftar');
            return;
        }

        // Create new option and add to select
        const option = document.createElement('option');
        option.value = categoryName;
        option.textContent = categoryName;
        option.selected = true;
        select.appendChild(option);

        closeCategoryModalBooks();
        alert('Kategori "' + categoryName + '" berhasil ditambahkan!');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('newCategoryInputBooks');
        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addNewCategoryBooks();
                }
            });
        }
    });
</script>
@endsection