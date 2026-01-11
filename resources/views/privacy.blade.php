<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - Ruang Aksara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(29,78,63,0.9), rgba(16,59,46,0.9)), url('/images/background.jpg') center/cover fixed no-repeat;
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="text-gray-800">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white/90 shadow-2xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 px-8 py-10 text-white">
                <p class="text-sm uppercase tracking-wide mb-2">Dokumen Privasi</p>
                <h1 class="text-3xl font-bold">Kebijakan Privasi Ruang Aksara</h1>
                <p class="mt-3 text-emerald-50">Kami berkomitmen melindungi data pribadi Anda saat berbelanja dan menggunakan layanan kami.</p>
                <p class="mt-4 text-emerald-100 text-sm">Diperbarui: 03 Januari 2026</p>
            </div>

            <div class="px-8 py-10 space-y-10">
                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-user-shield"></i> Data yang Kami Kumpulkan</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Informasi akun: nama, email, kata sandi terenkripsi, dan nomor kontak (jika diberikan).</li>
                        <li>Data pengiriman dan alamat: provinsi, kota, kecamatan, serta detail penerima untuk pesanan.</li>
                        <li>Data pemesanan & pembayaran: riwayat transaksi, metode pembayaran yang digunakan, dan status pesanan.</li>
                        <li>Data teknis: log perangkat, cookie, dan informasi sesi untuk menjaga keamanan login.</li>
                    </ul>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-hand-holding-heart"></i> Cara Kami Menggunakan Data</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Memproses pesanan, pengiriman, dan dukungan pelanggan.</li>
                        <li>Menampilkan riwayat transaksi, poin reward, dan status pesanan di akun Anda.</li>
                        <li>Mengirim notifikasi penting (pembayaran, pengiriman, reset kata sandi) melalui email/WhatsApp jika diizinkan.</li>
                        <li>Menjaga keamanan akun, mendeteksi aktivitas mencurigakan, dan mencegah penyalahgunaan.</li>
                    </ul>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-cookie-bite"></i> Cookie & Pelacakan</h2>
                    <p class="text-gray-700">Kami menggunakan cookie sesi untuk menjaga Anda tetap login dan mengingat preferensi. Anda dapat menonaktifkan cookie melalui pengaturan browser, namun beberapa fitur mungkin tidak berfungsi optimal.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-shield-alt"></i> Berbagi Data</h2>
                    <p class="text-gray-700">Kami hanya membagikan data Anda dengan mitra pengiriman, pembayaran, dan penyedia layanan yang diperlukan untuk menyelesaikan transaksi. Kami tidak menjual data pribadi Anda.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-lock"></i> Keamanan</h2>
                    <p class="text-gray-700">Kata sandi disimpan dengan enkripsi, koneksi dilindungi HTTPS, dan akses internal dibatasi. Jika Anda mencurigai aktivitas tidak wajar, segera hubungi kami.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-user-check"></i> Hak Anda</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Memperbarui atau menghapus profil akun.</li>
                        <li>Meminta salinan data pribadi yang kami simpan.</li>
                        <li>Mencabut izin komunikasi promosi kapan saja.</li>
                    </ul>
                </section>

                <section class="space-y-3">
                    <h2 class="text-xl font-semibold text-emerald-800 flex items-center gap-2"><i class="fas fa-envelope-open-text"></i> Kontak</h2>
                    <p class="text-gray-700">Punya pertanyaan soal privasi? Hubungi kami di <a href="mailto:ruangg.aksara@gmail.com" class="text-emerald-700 font-semibold hover:underline">ruangg.aksara@gmail.com</a> atau melalui menu bantuan di aplikasi.</p>
                </section>

                <div class="pt-6 flex justify-between items-center text-sm">
                    <a href="{{ route('welcome') }}" class="text-emerald-700 hover:text-emerald-800 font-semibold"><i class="fas fa-arrow-left mr-2"></i>Kembali ke halaman utama</a>
                    <a href="{{ route('terms') }}" class="text-emerald-700 hover:text-emerald-800 font-semibold">Lihat Syarat & Ketentuan<i class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
