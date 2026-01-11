<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Ruang Aksara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        body {
            background:
                linear-gradient(rgba(10, 34, 25, 0.12), rgba(10, 34, 25, 0.12)),
                url('/images/background.jpg') center/cover fixed no-repeat !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
            line-height: 1.6;
        }

        .page-header h1 {
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .page-header p {
            color: #334155;
        }

        .hero-header {
            background: linear-gradient(135deg, rgba(45, 90, 61, 0.15) 0%, rgba(30, 62, 42, 0.1) 100%);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(163, 230, 53, 0.2);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hero-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-title-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: center;
        }

        .hero-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .hero-kicker {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            background: rgba(163, 230, 53, 0.16);
            color: #d9f99d;
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid rgba(163, 230, 53, 0.35);
        }

        .hero-badge {
            position: relative;
            z-index: 1;
            background: rgba(22, 101, 52, 0.9);
            color: #e2e8f0;
            padding: 0.85rem 1.4rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.28);
            border: 1px solid rgba(34, 197, 94, 0.35);
        }

        .hero-badge span {
            display: block;
            font-size: 0.85rem;
            color: #cbd5e1;
        }

        .hero-badge strong {
            font-size: 1.15rem;
            color: #a3e635;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(245, 250, 246, 0.98), rgba(240, 248, 242, 0.95));
            border: 1px solid rgba(163, 230, 53, 0.15);
            border-radius: 1.25rem;
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.08);
            color: #2d3748;
        }

        .info-card h3 {
            color: #2d5a3d;
        }

        .info-card p {
            color: #4a5568;
        }

        .info-card strong {
            color: #1e3e2a;
        }

        .content-card {
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            border-radius: 1.5rem;
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.08);
            border: 1px solid rgba(163, 230, 53, 0.1);
        }

        .stat-card {
            border-radius: 1rem;
            padding: 1.1rem 1.25rem;
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.08);
            border: 1px solid rgba(163, 230, 53, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }

        .stat-blue {
            border-color: rgba(79, 172, 254, 0.2);
            background: linear-gradient(135deg, rgba(224, 242, 254, 0.6), rgba(248, 251, 255, 0.8));
            color: #0b5e86;
        }

        .stat-green {
            border-color: rgba(163, 230, 53, 0.25);
            background: linear-gradient(135deg, rgba(220, 252, 231, 0.7), rgba(240, 253, 244, 0.9));
            color: #0f5132;
        }

        .stat-yellow {
            border-color: rgba(251, 191, 36, 0.2);
            background: linear-gradient(135deg, rgba(254, 243, 195, 0.6), rgba(255, 252, 235, 0.9));
            color: #78350f;
        }

        .stat-purple {
            border-color: rgba(168, 85, 247, 0.2);
            background: linear-gradient(135deg, rgba(237, 233, 254, 0.6), rgba(250, 245, 255, 0.9));
            color: #5b21b6;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .orders-table thead th {
            background-color: #2d5a3d;
            color: #ffffff;
            border-bottom: 2px solid rgba(163, 230, 53, 0.2);
            font-weight: 700;
        }

        .orders-table th,
        .orders-table td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
        }

        .orders-table tbody tr {
            border-bottom: 1px solid rgba(163, 230, 53, 0.1);
            background: #ffffff;
            transition: background-color 0.2s ease;
        }

        .orders-table tbody tr:nth-child(even) {
            background: rgba(245, 250, 246, 0.6);
        }

        .orders-table tbody tr:hover {
            background-color: rgba(163, 230, 53, 0.08);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            border-radius: 9999px;
            font-weight: 700;
            padding: 0.4rem 0.9rem;
            color: #2d5a3d;
            background: rgba(163, 230, 53, 0.15);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
        }

        .status-pending {
            background: rgba(251, 146, 60, 0.15);
            color: #92400e;
        }

        .status-processing {
            background: rgba(163, 230, 53, 0.2);
            color: #2d5a3d;
        }

        .status-shipped {
            background: rgba(163, 230, 53, 0.15);
            color: #2d5a3d;
        }

        .status-received,
        .status-delivered,
        .status-verified {
            background: rgba(34, 197, 94, 0.15);
            color: #166534;
        }

        .status-cancelled,
        .status-failed {
            background: rgba(239, 68, 68, 0.15);
            color: #7f1d1d;
        }
    </style>
</head>
<body class="font-sans antialiased">
    @auth
        @if(auth()->user()->role === 'user')
        <button id="hamburgerBtn" class="hamburger-btn" type="button" title="Toggle Sidebar" aria-controls="sidebar" aria-expanded="false" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div id="sidebarOverlay" class="sidebar-overlay"></div>

        <aside class="sidebar" id="sidebar">
            @include('partials.user-sidebar-content')
        </aside>
        @endif
    @endauth

    <div class="main-wrapper sidebar-open" id="mainWrapper">
        <div class="content-wrapper">
            <div class="mx-auto max-w-6xl space-y-6">
                <header class="hero-header">
                    <div class="hero-text">
                        <div class="hero-title-row">
                            <div class="hero-icon" style="font-size: 2.5rem; color: #a3e635;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h1 style="color: #a3e635; font-size: 2.25rem; margin: 0; font-weight: 800; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px;">Riwayat Pesanan</h1>
                        </div>
                        <p style="color: #ffffff; font-size: 1.05rem; margin: 0; text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3); font-weight: 500;">Lihat semua pesanan buku yang telah Anda buat untuk memperkaya wawasan dan perjalanan bacaan Anda.</p>
                    </div>
                </header>

                <section class="info-card rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1 flex-shrink-0"></i>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-blue-800">Status Pembayaran</h3>
                            <p class="text-sm text-blue-700">
                                <strong>Pembayaran Menunggu:</strong> Bukti pembayaran Anda sedang menunggu verifikasi dari admin.<br>
                                <strong>Pembayaran Terverifikasi:</strong> Pembayaran Anda telah disetujui dan pesanan akan segera diproses.<br>
                                <strong>Pembayaran Ditolak:</strong> Pembayaran Anda ditolak. Hubungi admin untuk bantuan.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="content-card border p-6">
                    @if($orders->count() > 0)
                        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div class="stat-card stat-blue">
                                <div class="text-sm font-medium text-blue-600">Total Pesanan</div>
                                <div class="text-2xl font-bold text-blue-800">{{ $orders->count() }}</div>
                            </div>
                            <div class="stat-card stat-green">
                                <div class="text-sm font-medium text-green-600">Selesai</div>
                                <div class="text-2xl font-bold text-green-800">{{ $orders->where('status', 'delivered')->count() }}</div>
                            </div>
                            <div class="stat-card stat-yellow">
                                <div class="text-sm font-medium text-yellow-600">Diproses</div>
                                <div class="text-2xl font-bold text-yellow-800">{{ $orders->whereIn('status', ['pending', 'processing'])->count() }}</div>
                            </div>
                            <div class="stat-card stat-purple">
                                <div class="text-sm font-medium text-purple-600">Total Belanja</div>
                                <div class="text-2xl font-bold text-purple-800">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full orders-table">
                                <thead>
                                    <tr class="border-b-2 border-gray-300">
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Order ID</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Buku</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Jumlah</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Harga</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($groupedOrders as $groupKey => $group)
                                        @php 
                                            $groupKeyId = 'grp_' . str_replace([' ', ':', '-'], '_', $groupKey);
                                            $first = $group->first();
                                            $allItems = $group->flatMap(fn($order) => $order->items);
                                        @endphp
                                        <tr class="transition hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                                <div class="flex flex-col gap-1">
                                                    <span class="font-semibold text-blue-700">{{ $groupKey ?: '#'.$group->first()->id }}</span>
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2 py-0.5 text-[11px] text-blue-800">
                                                        <i class="fas fa-book"></i>{{ $allItems->count() }} buku
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 align-top text-sm text-gray-700">
                                                @php $limitBooks = $allItems->take(2); $hiddenBooks = $allItems->skip(2); @endphp
                                                <div class="flex flex-col gap-2">
                                                    @foreach($limitBooks as $item)
                                                        <div class="flex items-center gap-2">
                                                            @if($item->book && ($item->book->image ?? false))
                                                                <img src="{{ asset('storage/book-covers/' . $item->book->image) }}" alt="{{ $item->book->judul ?? 'Buku' }}" class="h-10 w-8 rounded object-cover">
                                                            @else
                                                                <div class="flex h-10 w-8 items-center justify-center rounded bg-gray-300">
                                                                    <i class="fas fa-book text-xs text-gray-600"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="font-medium leading-tight">{{ $item->book->judul ?? 'Buku tidak tersedia' }}</p>
                                                                <p class="text-[11px] text-gray-600">{{ $item->book->penulis ?? 'Unknown' }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if($allItems->count() > 2)
                                                        <details class="text-[11px]">
                                                            <summary class="cursor-pointer text-blue-600 hover:underline">Lihat {{ $allItems->count() - 2 }} buku lain</summary>
                                                            <div class="mt-2 space-y-2">
                                                                @foreach($hiddenBooks as $item)
                                                                    <div class="flex items-center gap-2">
                                                                        @if($item->book && ($item->book->image ?? false))
                                                                            <img src="{{ asset('storage/book-covers/' . $item->book->image) }}" alt="{{ $item->book->judul ?? 'Buku' }}" class="h-9 w-7 rounded object-cover">
                                                                        @else
                                                                            <div class="flex h-9 w-7 items-center justify-center rounded bg-gray-300">
                                                                                <i class="fas fa-book text-[10px] text-gray-600"></i>
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <p class="text-xs font-medium leading-tight">{{ $item->book->judul ?? 'Buku tidak tersedia' }}</p>
                                                                            <p class="text-[10px] text-gray-600">{{ $item->book->penulis ?? 'Unknown' }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </details>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ optional($first->created_at)->format('d M Y') }}<br>
                                                <span class="text-xs text-gray-600">{{ optional($first->created_at)->format('H:i') }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $allItems->sum('quantity') }}</td>
                                            <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                                                Rp {{ number_format($first->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-center align-top">
                                                <div class="flex flex-col items-center gap-1 text-xs leading-tight text-gray-700">
                                                    @if($first && $first->payment_method != 'cash')
                                                        <span class="status-badge status-{{ $first->payment_status ?? 'pending' }}">
                                                            @if(($first->payment_status ?? 'pending') == 'pending')
                                                                Menunggu Verifikasi
                                                            @elseif($first->payment_status == 'verified')
                                                                Terverifikasi
                                                            @elseif($first->payment_status == 'failed')
                                                                Ditolak
                                                            @endif
                                                        </span>
                                                    @endif
                                                    <span class="status-badge status-{{ $first->status ?? 'pending' }}">
                                                        @if($first->status == 'pending')
                                                            Menunggu
                                                        @elseif($first->status == 'processing')
                                                            Diproses
                                                        @elseif($first->status == 'shipped')
                                                            Dikirim
                                                        @elseif($first->status == 'received')
                                                            Diterima
                                                        @elseif($first->status == 'delivered')
                                                            Selesai
                                                        @else
                                                            Dibatalkan
                                                        @endif
                                                    </span>
                                                    <span class="text-[11px] {{ $first->tracking_number ? 'text-gray-600' : 'text-gray-500' }}">
                                                        {{ $first->tracking_number ? 'Resi: '.$first->tracking_number : 'Resi belum tersedia' }}
                                                    </span>
                                                    @if($first->confirmed_by_user)
                                                        <span class="text-[11px] text-green-700">Sudah dikonfirmasi</span>
                                                    @elseif(in_array($first->status, ['shipped','processing','delivered']))
                                                        <form method="POST" action="{{ route('orders.confirm', $first->id) }}" class="mt-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="text-[11px] text-blue-600 hover:underline">Tandai Diterima</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('orders.show', $group->first()->id) }}" class="inline-flex items-center rounded bg-green-600 px-3 py-2 text-sm text-white transition hover:bg-green-700">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-center">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="space-y-6 py-12 text-center">
                            <div class="text-6xl text-gray-300">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-gray-800">Belum ada pesanan</h2>
                                <p class="mx-auto max-w-md text-gray-600">Anda belum melakukan pemesanan buku. Yuk jelajahi katalog buku kami untuk menemukan bacaan menarik!</p>
                            </div>
                            <a href="{{ route('books.index') }}" class="inline-flex items-center rounded-lg bg-green-600 px-6 py-3 text-white transition hover:bg-green-700">
                                <i class="fas fa-book mr-2"></i> Jelajahi Buku
                            </a>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>

    <div class="nav-buttons">
        <button type="button" onclick="window.history.back()" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </button>
        <button type="button" onclick="window.history.forward()" title="Maju">
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    @include('partials.welcome-footer', ['hasSidebar' => auth()->check() && auth()->user()->role === 'user'])
</body>
</html>