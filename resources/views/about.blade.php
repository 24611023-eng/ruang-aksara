<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - Ruang Aksara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(rgba(29,78,63,0.55), rgba(16,59,46,0.55)), url('/images/background.jpg') center/cover fixed no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-card { 
            background: rgba(255,255,255,0.7); 
            backdrop-filter: blur(10px); 
            box-shadow: 0 15px 45px rgba(0,0,0,0.12); 
        }
        .team-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15), 0 0 0 4px rgba(255,255,255,0.2);
        }
        .story-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }
        .floating-card {
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .floating-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        .owner-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            font-size: 0.65rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
            letter-spacing: 0.5px;
        }
        .admin-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 0.65rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            letter-spacing: 0.5px;
        }
        .service-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 30px;
        }
        .peminjaman-icon {
            background: linear-gradient(135deg, #93c5fd, #3b82f6);
            color: white;
        }
        .penjualan-icon {
            background: linear-gradient(135deg, #86efac, #10b981);
            color: white;
        }
        .komunitas-icon {
            background: linear-gradient(135deg, #fbbf24, #d97706);
            color: white;
        }
    </style>
</head>
<body class="text-gray-900">
    <nav class="shadow-lg sticky top-0 z-50" style="background: linear-gradient(135deg, #2d5a3d 0%, #1e3e2a 100%) !important;">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-2xl font-bold text-white flex items-center gap-0">
                    @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
                        <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Ruang Aksara" class="h-16 mr-0 inline-block" />
                    @else
                        <img src="{{ asset('images/ruang-aksara-logo.svg') }}" alt="Ruang Aksara" class="h-16 mr-0 inline-block" />
                    @endif
                    <span style="color:#FFD600">Ruang Aksara</span>
                </a>
                <div class="flex gap-2">
                    <a href="/" class="px-4 py-2 rounded-lg border border-white/35 text-white/90 hover:text-white hover:bg-white/10 transition font-semibold">Home</a>
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition font-semibold shadow-sm">About</span>
                    <a href="/books" class="px-4 py-2 rounded-lg border border-white/35 text-white/90 hover:text-white hover:bg-white/10 transition font-semibold">Katalog Buku</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-16" style="flex:1 1 auto;">
        <div class="container mx-auto px-4 max-w-6xl space-y-16">
            <!-- Header -->
            <div class="bg-white/70 backdrop-blur rounded-lg shadow-md p-8 text-center border border-white/30">
                <h1 class="text-4xl font-bold mb-4">
                    <i class="fas fa-book-open" style="color: #16a34a;"></i> 
                    <span style="color: #16a34a;">Tentang Kami</span>
                </h1>
                <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Jelajahi perjalanan Ruang Aksara dalam menyediakan akses terbaik untuk literasi Indonesia
                </p>
            </div>

            <!-- Layanan Kami Section -->
            <div class="p-8 rounded-2xl glass-card floating-card">
                <h2 class="text-3xl font-bold text-center text-green-900 mb-10">Layanan Unggulan Kami</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="p-6 rounded-xl border border-white/30 bg-white/70 backdrop-blur text-center shadow-md">
                        <div class="service-icon peminjaman-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Peminjaman Buku Fisik</h3>
                        <p class="text-gray-600 mb-4 text-justify">Peminjaman hanya tersedia melalui toko offline kami.</p>
                        <ul class="text-sm text-gray-700 text-left space-y-2">
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Peminjaman gratis tanpa biaya</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Lihat daftar buku yang tersedia untuk dipinjam melalui website</li>
                        </ul>
                    </div>
                    
                        <div class="p-6 rounded-xl border border-white/30 bg-white/70 backdrop-blur text-center shadow-md">
                        <div class="service-icon penjualan-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Penjualan Buku Baru</h3>
                        <p class="text-gray-600 mb-4 text-justify">Temukan buku baru terbitan terkini dengan harga terjangkau. Semua buku melalui proses kurasi ketat.</p>
                        <ul class="text-sm text-gray-700 text-left space-y-2">
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Garansi kualitas 100%</li>
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Pengiriman cepat 1-3 hari</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cerita Kami Section -->
            <div class="p-8 rounded-2xl glass-card floating-card">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-12 h-12 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl">
                        <i class="fas fa-history"></i>
                    </span>
                    <h2 class="text-3xl font-bold text-green-900">Cerita Kami</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-10 items-center">
                    <div>
                        <p class="text-gray-700 leading-relaxed text-lg mb-4 text-justify">
                            <span class="font-bold text-green-700">Ruang Aksara</span> didirikan pada tahun 2020 dengan misi revolusioner: membuat akses terhadap buku menjadi lebih mudah, terjangkau, dan berkelanjutan bagi semua orang di Indonesia.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg mb-4 text-justify">
                            Kami memulai sebagai perpustakaan komunitas kecil yang meminjamkan buku secara gratis. Seiring waktu, kami menyadari bahwa banyak pembaca yang ingin memiliki koleksi pribadi, sementara yang lain memiliki buku yang sudah tidak dibaca lagi.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg text-justify">
                            Dari sinilah lahir konsep hybrid: <span class="font-semibold text-green-700">marketplace dan juga perpustakaan</span>. Sekarang, Anda bisa meminjam buku untuk dibaca atau membeli buku baru untuk koleksi.
                        </p>
                    </div>
                    <div>
                                <img src="{{ asset('images/cerita.jpeg') }}" 
                                    alt="Ruang baca Ruang Aksara" 
                                    class="story-img shadow-lg">
                    </div>
                </div>
            </div>

            <!-- Visi & Misi Section -->
            <div class="p-8 rounded-2xl glass-card floating-card">
                <h2 class="text-3xl font-bold text-center text-green-900 mb-10">Visi & Misi Kami</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Visi -->
                    <div class="p-6 rounded-xl border border-white/30 bg-white/70 backdrop-blur shadow-md">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xl">V</span>
                            <h3 class="text-2xl font-bold text-green-900">Visi</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-justify">Menjadi ekosistem literasi digital terintegrasi pertama di Indonesia yang menghubungkan pembaca, penulis, dan penerbit dalam satu platform yang berkelanjutan.</p>
                    </div>
                    
                    <!-- Misi -->
                    <div class="p-6 rounded-xl border border-white/30 bg-white/70 backdrop-blur shadow-md">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl">M</span>
                            <h3 class="text-2xl font-bold text-green-900">Misi</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-sm mt-1 flex-shrink-0"><i class="fas fa-book"></i></span>
                                <span class="text-gray-700"><span class="font-semibold">Memperluas Akses Buku:</span> Menyediakan layanan peminjaman buku fisik gratis tanpa biaya.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-sm mt-1 flex-shrink-0"><i class="fas fa-shopping-cart"></i></span>
                                <span class="text-gray-700"><span class="font-semibold">Memfasilitasi Perdagangan Buku:</span> Menyediakan platform jual-beli buku baru berkualitas.</span>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tim Kami dengan 6 Anggota -->
            <div class="p-8 rounded-2xl glass-card border border-white/30 floating-card">
                <div class="flex items-center gap-3 mb-8">
                    <span class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl">
                        <i class="fas fa-users"></i>
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900">Tim Kami</h2>
                </div>
                    
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- 1. Syifa Nabila Motumona - CEO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/Syifa%20Nabila%20Motumona.jpeg" 
                                 alt="Syifa Nabila Motumona - Chief Executive Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">Syifa Nabila Motumona</div>
                            <div class="text-sm text-amber-600 font-semibold mb-2">Chief Executive Officer (CEO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Pemimpin tertinggi:</span> pengambil keputusan strategis.</li>
                                <li><span class="font-semibold">Peran eksternal:</span> menetapkan visi, misi, arah pengembangan, dan mewakili organisasi.</li>
                            </ul>
                        </div>

                    <!-- 2. Nur Rana Faizah - CFO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/Nur%20Rana%20Faizah.jpeg" 
                                 alt="Nur Rana Faizah - Chief Financial Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">Nur Rana Faizah</div>
                            <div class="text-sm text-emerald-600 font-semibold mb-2">Chief Financial Officer (CFO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Tanggung jawab:</span> pengelolaan keuangan organisasi.</li>
                                <li><span class="font-semibold">Fungsi utama:</span> menyusun anggaran, laporan keuangan, dan memastikan keberlanjutan finansial.</li>
                            </ul>
                        </div>

                    <!-- 3. Nariswari Elvina Maharani - CMO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/Nariswari%20Elvina%20Maharani.jpeg" 
                                 alt="Nariswari Elvina Maharani - Chief Marketing & Communication Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">Nariswari Elvina Maharani</div>
                            <div class="text-sm text-purple-600 font-semibold mb-2">Chief Marketing & Communication Officer (CMO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Pemasaran & Komunikasi:</span> memimpin branding, media sosial, publikasi, dan komunikasi eksternal.</li>
                            </ul>
                        </div>

                    <!-- 4. Muhammad Rizzat Asyrafilarzaq - COO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/Muhammad%20Rizzat%20Asyrafilarzaq.jpeg" 
                                 alt="Muhammad Rizzat Asyrafilarzaq - Chief Operating Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">Muhammad Rizzat Asyrafilarzaq</div>
                            <div class="text-sm text-emerald-600 font-semibold mb-2">Chief Operating Officer (COO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Operasional:</span> mengelola operasional harian dan pelaksanaan program kegiatan.</li>
                            </ul>
                        </div>

                    <!-- 5. Ahmad Faiz Muzaki - CAO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/Ahmad%20Faiz%20Muzaki.jpeg" 
                                 alt="Ahmad Faiz Muzaki - Chief Administrative Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">Ahmad Faiz Muzaki</div>
                            <div class="text-sm text-green-600 font-semibold mb-2">Chief Administrative Officer (CAO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Administrasi:</span> pengelolaan arsip, legalitas, dan dokumentasi organisasi.</li>
                            </ul>
                        </div>

                    <!-- 6. M. Arif Al Ghifary - CPO -->
                    <div class="p-6 rounded-xl bg-white/80 backdrop-blur-sm border border-white/40 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                               <img src="/images/team/M.%20Arif%20Al%20Ghifary.jpeg" 
                                 alt="M. Arif Al Ghifary - Chief Program Officer" 
                                 class="team-img rounded-full mx-auto mb-4">
                            <div class="font-bold text-gray-900 text-lg">M. Arif Al Ghifary</div>
                            <div class="text-sm text-blue-600 font-semibold mb-2">Chief Program Officer (CPO)</div>
                            <ul class="text-sm text-gray-600 text-justify max-w-xs mx-auto mt-2 space-y-1">
                                <li><span class="font-semibold">Program:</span> perancangan dan pengembangan program literasi dan kegiatan utama.</li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.welcome-footer', ['hasSidebar' => false])
</body>
</html>