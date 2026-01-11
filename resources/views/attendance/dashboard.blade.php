@extends('layouts.app')

@section('content')
    <style>
        .attendance-hero {
            margin: 0 auto 1.5rem;
            width: 100%;
            max-width: 1100px;
            padding: 2.75rem 1.5rem;
            border: 1.6px solid rgba(163, 230, 53, 0.75);
            border-radius: 22px;
            background: rgba(42, 71, 63, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.12);
            text-align: center;
        }
        .attendance-hero__inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.65rem;
            color: #f8fafc;
        }
        .attendance-hero__title {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 2.1rem;
            font-weight: 800;
            color: #a3e635;
            letter-spacing: 0.02em;
        }
        .attendance-hero__icon {
            font-size: 2.1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .attendance-hero__subtitle {
            font-size: 1.05rem;
            color: #e2e8f0;
            margin: 0;
            line-height: 1.6;
        }
        .attendance-hero__meta {
            font-size: 0.95rem;
            color: #d1d5db;
            margin-top: 0.35rem;
        }

        /* Riwayat Presensi Card */
        .attendance-history-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 18px;
            padding: 1.75rem;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .attendance-card-header {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1.25rem;
        }
        .attendance-card-header__meta {
            font-size: 0.85rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .attendance-filters {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            align-items: end;
            margin-bottom: 1.25rem;
        }
        .attendance-select {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #0f172a;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .attendance-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .attendance-btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            padding: 0.8rem 1.25rem;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .attendance-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.25);
        }
        .attendance-btn-ghost {
            background: transparent;
            color: #334155;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            font-weight: 700;
            transition: color 0.15s ease, border-color 0.15s ease, background 0.15s ease;
        }
        .attendance-btn-ghost:hover {
            color: #0f172a;
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .attendance-table-wrapper {
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 14px 36px rgba(15, 118, 110, 0.08);
        }
        .attendance-table thead {
            background: linear-gradient(90deg, #ecfdf3 0%, #d1fae5 100%);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        }
        .attendance-table th {
            font-size: 0.78rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #065f46;
            padding: 0.9rem 1rem;
            font-weight: 800;
        }
        .attendance-table td {
            padding: 1rem 1rem;
            color: #064e3b;
        }
        .attendance-table tbody tr {
            border-top: 1px solid #e5f5ec;
        }
        .attendance-table tr:nth-child(2n) {
            background: #f6fef9;
        }
        .attendance-table tr:hover {
            background: #e8f7ef;
        }
        .attendance-status-badge {
            padding: 0.45rem 0.95rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6);
        }
        @media (max-width: 768px) {
            .attendance-history-card {
                padding: 1.25rem;
            }
            .attendance-filters {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 640px) {
            .attendance-hero {
                padding: 2.25rem 1.2rem;
            }
            .attendance-hero__title {
                font-size: 1.7rem;
            }
            .attendance-hero__icon {
                font-size: 1.7rem;
            }
            .attendance-hero__subtitle {
                font-size: 0.98rem;
            }
        }
    </style>
    <div class="max-w-5xl mx-auto py-6 px-4">
        <div class="attendance-hero">
            <div class="attendance-hero__inner">
                <div class="attendance-hero__title">
                    <span class="attendance-hero__icon">🕒</span>
                    <span>Presensi Harian</span>
                </div>
                <p class="attendance-hero__subtitle">Pantau check-in, check-out, dan status presensi kamu di satu tempat.</p>
                <span id="real-time" class="attendance-hero__meta" style="font-weight:700;">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}</span>
            </div>
        </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Today's Attendance Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Status Presensi Hari Ini</h2>
                
                @if($todayAttendance)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-4 border rounded-lg {{ $todayAttendance->check_in ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="text-2xl font-bold {{ $todayAttendance->check_in ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') : '--:--' }}
                            </div>
                            <div class="text-sm text-gray-600">Check In</div>
                        </div>
                        
                        <div class="text-center p-4 border rounded-lg {{ $todayAttendance->check_out ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="text-2xl font-bold {{ $todayAttendance->check_out ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') : '--:--' }}
                            </div>
                            <div class="text-sm text-gray-600">Check Out</div>
                        </div>
                        
                        <div class="text-center p-4 border rounded-lg bg-blue-50 border-blue-200">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $todayAttendance->status_label }}
                            </div>
                            <div class="text-sm text-gray-600">Status</div>
                        </div>
                    </div>

                    @if(!$todayAttendance->check_out)
                        <form action="{{ route('attendance.checkout') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-4">
                                <label for="notes_checkout" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes_checkout" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan untuk presensi pulang...">{{ $todayAttendance->notes }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-semibold">
                                <i class="fas fa-sign-out-alt mr-2"></i>Presensi Pulang
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <p class="text-gray-600">Presensi hari ini sudah selesai.</p>
                        </div>
                    @endif

                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                        
                        @php
                            $now = \Carbon\Carbon::now();
                            $maxCheckInTime = \Carbon\Carbon::createFromTime(10, 0, 0);
                            $isCheckInClosed = $now->gt($maxCheckInTime);
                        @endphp

                        @if($isCheckInClosed)
                            <p class="text-red-600 font-semibold mb-4">Waktu check-in sudah ditutup!</p>
                            <p class="text-gray-500 mb-4">Check-in hanya dapat dilakukan hingga jam 10:00.</p>
                            <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                                <p class="text-red-700">Anda tidak dapat melakukan check-in lagi hari ini.</p>
                            </div>
                        @else
                            <p class="text-gray-500 mb-4">Belum ada presensi hari ini.</p>
                            <form action="{{ route('attendance.checkin') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="notes_checkin" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" id="notes_checkin" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan untuk presensi masuk..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-semibold">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Presensi Masuk
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Monthly Stats -->
            @if($monthlyStats)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Statistik Bulan Ini</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $monthlyStats->total_days ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Total Hari</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $monthlyStats->ontime_days ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Tepat Waktu</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $monthlyStats->late_days ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Terlambat</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $monthlyStats->absent_days ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Tidak Hadir</div>
                    </div>
                </div>
            </div>
            @endif

            @php
                $monthLabels = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            @endphp
            <div class="attendance-history-card mt-6">
                <div class="attendance-card-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Riwayat Presensi</h2>
                            <p class="text-sm text-gray-500">Pantau riwayat presensi kamu secara lengkap.</p>
                        </div>
                        <span class="attendance-card-header__meta">Terakhir diperbarui {{ now()->translatedFormat('d M Y H:i') }}</span>
                    </div>
                </div>

                <form method="GET" action="{{ route('employee.dashboard') }}" class="attendance-filters">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Pilih Tahun</label>
                        <select name="year" class="attendance-select">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $yearOption)
                                <option value="{{ $yearOption }}" {{ (string)$selectedYear === (string)$yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Pilih Bulan</label>
                        <select name="month" class="attendance-select">
                            <option value="">Semua Bulan</option>
                            @foreach($monthLabels as $number => $label)
                                <option value="{{ $number }}" {{ (int)$selectedMonth === $number ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="attendance-btn-primary">Terapkan</button>
                        <a href="{{ route('employee.dashboard') }}" class="attendance-btn-ghost">Reset</a>
                    </div>
                </form>

                @if(isset($attendanceHistory) && $attendanceHistory->isNotEmpty())
                    <div class="attendance-table-wrapper">
                        <table class="min-w-full attendance-table text-sm">
                            <thead>
                                <tr>
                                    <th class="text-left">Tanggal</th>
                                    <th class="text-left">Hari</th>
                                    <th class="text-left">Check-In</th>
                                    <th class="text-left">Check-Out</th>
                                    <th class="text-left">Durasi</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceHistory as $record)
                                    @php
                                        $dateInstance = $record->date ? \Carbon\Carbon::parse($record->date) : null;
                                        $checkInInstance = $record->check_in ? \Carbon\Carbon::parse($record->check_in) : null;
                                        $checkOutInstance = $record->check_out ? \Carbon\Carbon::parse($record->check_out) : null;
                                        $durationMinutes = ($checkInInstance && $checkOutInstance) ? $checkInInstance->diffInMinutes($checkOutInstance) : null;
                                        $durationText = $durationMinutes !== null
                                            ? sprintf('%02dj %02dm', intdiv($durationMinutes, 60), $durationMinutes % 60)
                                            : '—';
                                        $statusMap = [
                                            'ontime' => ['label' => 'Hadir (Tepat Waktu)', 'class' => 'bg-emerald-50 text-emerald-700 border border-emerald-200'],
                                            'late' => ['label' => 'Terlambat', 'class' => 'bg-amber-50 text-amber-700 border border-amber-200'],
                                            'absent' => ['label' => 'Tidak Hadir', 'class' => 'bg-rose-50 text-rose-700 border border-rose-200'],
                                            'default' => ['label' => ucfirst($record->status ?? 'Tidak Diketahui'), 'class' => 'bg-slate-50 text-slate-600 border border-slate-200']
                                        ];
                                        $statusKey = $record->status ?? ($record->check_in ? 'ontime' : 'absent');
                                        $statusMeta = $statusMap[$statusKey] ?? ['label' => ucfirst($statusKey ?? 'Tidak Diketahui'), 'class' => 'bg-slate-50 text-slate-600 border border-slate-200'];
                                    @endphp
                                    <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        {{ $dateInstance ? $dateInstance->translatedFormat('d F Y') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $dateInstance ? $dateInstance->translatedFormat('l') : '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $checkInInstance ? $checkInInstance->format('H:i') : '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $checkOutInstance ? $checkOutInstance->format('H:i') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 font-mono text-sm">
                                        {{ $durationText }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="attendance-status-badge text-xs font-semibold {{ $statusMeta['class'] }}">
                                            {{ $statusMeta['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $record->notes ? \Illuminate\Support\Str::limit($record->notes, 60) : '—' }}
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500">
                        Belum ada riwayat presensi yang dapat ditampilkan.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Update waktu real-time
        function updateRealTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            
            // Format untuk Indonesia
            const formatter = new Intl.DateTimeFormat('id-ID', options);
            document.getElementById('real-time').textContent = formatter.format(now);
        }

        // Update setiap detik
        setInterval(updateRealTime, 1000);
        updateRealTime(); // Jalankan pertama kali
    </script>
@endsection
</body>
</html>