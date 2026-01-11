<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Presensi masuk
    public function checkIn(Request $request)
    {
        // Debug logging: record auth state to help trace redirect issues
        \Log::info('Attendance checkIn called', [
            'auth_check' => Auth::check(),
            'employee_guard_check' => Auth::guard('employee')->check(),
            'user_id' => Auth::id(),
            'employee_id' => Auth::guard('employee')->id(),
            'session_all' => array_keys($request->session()->all())
        ]);

        // Support both regular users and employees
        $now = now();
        $checkInTime = $now->format('H:i:s');

        // Tentukan status - Terlambat jika check-in melebihi jam 07:30
        $lateThreshold = Carbon::createFromTime(7, 30, 0);
        $checkIn = Carbon::createFromTime($now->hour, $now->minute, $now->second);
        $status = $checkIn->gt($lateThreshold) ? 'late' : 'ontime';

        // Jika pegawai sedang login
        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            if (Attendance::hasEmployeeCheckedInToday($employee->id)) {
                return redirect()->back()->with('error', 'Anda sudah presensi masuk hari ini!');
            }

            Attendance::create([
                'employee_id' => $employee->id,
                'date' => Carbon::today(),
                'check_in' => $checkInTime,
                'status' => $status,
                'notes' => $request->notes
            ]);

            $message = $status == 'ontime' ? 'Presensi masuk tepat waktu!' : 'Presensi masuk terlambat!';
            return redirect()->back()->with('success', $message);
        }

        // Default: regular user
        $user = Auth::user();
        if (!$user) {
            \Log::warning('Attendance checkIn: no authenticated user found after guards check', ['session_keys' => array_keys($request->session()->all())]);
            return redirect()->back()->with('error', 'Harus login terlebih dahulu.');
        }

        if (Attendance::hasCheckedInToday($user->id)) {
            return redirect()->back()->with('error', 'Anda sudah presensi masuk hari ini!');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'check_in' => $checkInTime,
            'status' => $status,
            'notes' => $request->notes
        ]);

        $message = $status == 'ontime' ? 'Presensi masuk tepat waktu!' : 'Presensi masuk terlambat!';
        return redirect()->back()->with('success', $message);
    }

    // Presensi pulang
    public function checkOut(Request $request)
    {
        // Support employees and users
        $now = now();
        $checkOutTime = $now->format('H:i:s');
        $maxCheckOutTime = Carbon::createFromTime(22, 0, 0);
        $currentTime = Carbon::createFromTime($now->hour, $now->minute, $now->second);

        if ($currentTime->gt($maxCheckOutTime)) {
            return redirect()->back()->with('error', 'Checkout hanya dapat dilakukan maksimal hingga jam 22:00. Sistem telah otomatis melakukan checkout pada jam 22:00.');
        }

        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            $attendance = Attendance::where('employee_id', $employee->id)->where('date', now()->format('Y-m-d'))->first();

            if (!$attendance) {
                return redirect()->back()->with('error', 'Anda belum presensi masuk hari ini!');
            }
            if ($attendance->check_out) {
                return redirect()->back()->with('error', 'Anda sudah presensi pulang hari ini!');
            }

            $attendance->update([
                'check_out' => $checkOutTime,
                'notes' => $request->notes ?: $attendance->notes
            ]);

            return redirect()->back()->with('success', 'Presensi pulang berhasil!');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Harus login terlebih dahulu.');
        }

        $attendance = Attendance::today($user->id)->first();
        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum presensi masuk hari ini!');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Anda sudah presensi pulang hari ini!');
        }

        $attendance->update([
            'check_out' => $checkOutTime,
            'notes' => $request->notes ?: $attendance->notes
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil!');
    }

    // Lihat riwayat presensi
    public function history(Request $request)
    {
        $user = Auth::user();
        
        $query = Attendance::where('user_id', $user->id);

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            
            $query->dateRange($startDate, $endDate);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->paginate(20);

        return view('attendance.history', compact('attendances'));
    }

    // Dashboard presensi
    public function dashboard()
    {
        $user = Auth::user();

        // Data hari ini
        $todayAttendance = Attendance::today($user->id)->first();

        // Statistik bulan ini menggunakan method dari model
        $monthlyStats = Attendance::getMonthlyStats($user->id);

        return view('attendance.dashboard', compact('todayAttendance', 'monthlyStats'));
    }

    // Store attendance (untuk kompatibilitas dengan route yang ada)
    public function store(Request $request)
    {
        return $this->checkIn($request);
    }

    // Detail presensi untuk owner - Lihat semua staff
    public function detail(Request $request)
    {
        // Get month and year from request, default to current month
        if ($request->filled('year') && $request->filled('month_num')) {
            $month = $request->input('year') . '-' . str_pad($request->input('month_num'), 2, '0', STR_PAD_LEFT);
        } elseif ($request->filled('month')) {
            $month = $request->input('month');
        } else {
            $month = now()->format('Y-m');
        }
        $monthCarbon = Carbon::parse($month . '-01');
        
        // Get all staff users (admin/owner) and employees so owner can view all staff presensi
        $staffUsers = User::whereIn('role', ['admin', 'owner'])->orderBy('name')->get();
        $employees = \App\Models\Employee::orderBy('name')->get();
        
        // Get all attendance records for the selected month
        $startDate = $monthCarbon->copy()->startOfMonth()->toDateString();
        $endDate = $monthCarbon->copy()->endOfMonth()->toDateString();
        
        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])->get();
        
        // Group by member (user or employee) and date - normalize date format
        $attendanceByMemberAndDate = [];
        foreach ($attendances as $att) {
            $attDate = Carbon::parse($att->date)->toDateString();
            if (!empty($att->user_id)) {
                $key = 'user_' . $att->user_id . '_' . $attDate;
            } elseif (!empty($att->employee_id)) {
                $key = 'emp_' . $att->employee_id . '_' . $attDate;
            } else {
                continue;
            }
            $attendanceByMemberAndDate[$key] = $att;
        }
        
        // Calculate monthly stats
        $totalWorkDays = $monthCarbon->daysInMonth;
        $hadir = 0; $izin = 0; $alfa = 0; $terlambat = 0;
        $today = now()->startOfDay(); // Tanggal hari ini
        
        // Build unified staff list: users then employees
        $members = [];
        foreach ($staffUsers as $user) {
            $members[] = (object)[ 'type' => 'user', 'id' => $user->id, 'name' => $user->name, 'model' => $user ];
        }
        foreach ($employees as $emp) {
            $members[] = (object)[ 'type' => 'employee', 'id' => $emp->id, 'name' => $emp->name, 'model' => $emp ];
        }

        $attendanceData = [];
        foreach ($members as $member) {
            $memberStats = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'alfa' => 0];
            $dailyData = [];

            for ($day = 1; $day <= $totalWorkDays; $day++) {
                $currentDate = $monthCarbon->copy()->day($day)->startOfDay();
                $dateString = $currentDate->toDateString();

                $key = ($member->type === 'user' ? 'user_' : 'emp_') . $member->id . '_' . $dateString;
                $attendance = isset($attendanceByMemberAndDate[$key]) ? $attendanceByMemberAndDate[$key] : null;

                if ($currentDate->isAfter($today)) {
                    $status = 'belum_terjadi';
                } elseif ($attendance && $attendance->check_in) {
                    $checkInTime = Carbon::parse($attendance->check_in);
                    $lateThreshold = Carbon::createFromTime(7, 30, 0);

                    if ($checkInTime->gt($lateThreshold)) {
                        $status = 'terlambat';
                        $memberStats['terlambat']++;
                        $terlambat++;
                    } else {
                        $status = 'hadir';
                        $memberStats['hadir']++;
                        $hadir++;
                    }
                } elseif ($attendance && $attendance->status === 'izin') {
                    $status = 'izin';
                    $memberStats['izin']++;
                    $izin++;
                } else {
                    $status = 'alfa';
                    $memberStats['alfa']++;
                    $alfa++;
                }

                $dailyData[$day] = [
                    'status' => $status,
                    'attendance' => $attendance
                ];
            }

            $attendanceData[] = [
                'user' => $member->model,
                'stats' => $memberStats,
                'daily' => $dailyData
            ];
        }
        
        $totalStaff = $staffUsers->count() + $employees->count();
        
        return view('admin.attendance.detail', compact('attendanceData', 'totalStaff', 'hadir', 'izin', 'alfa', 'terlambat', 'monthCarbon', 'totalWorkDays'));
    }

    // Owner updates attendance status for a member on a specific date
    public function updateStatus(Request $request)
    {
        $request->validate([
            'member_type' => 'required|in:user,employee',
            'member_id' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,alfa',
            // allow H:i or H:i:s
            'check_in' => ['nullable', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/']
        ]);

        $user = Auth::user();
        if (!$user || $user->role !== 'owner') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $memberType = $request->input('member_type');
        $memberId = $request->input('member_id');
        $date = $request->input('date');
        $status = $request->input('status');

        if ($memberType === 'user') {
            $attendance = Attendance::firstOrNew([
                'user_id' => $memberId,
                'date' => $date,
            ]);
        } else {
            $attendance = Attendance::firstOrNew([
                'employee_id' => $memberId,
                'date' => $date,
            ]);
        }

        // If the member did NOT presensi on the web (no check_in), owner should
        // NOT be allowed to mark them as 'hadir' or 'terlambat' unless a manual
        // `check_in` time is provided in the request.
        $attemptingSetPresent = in_array($status, ['hadir', 'terlambat'], true);
        if ($attemptingSetPresent && empty($attendance->check_in) && !$attendance->exists && !$request->filled('check_in')) {
            return redirect()->back()->with('error', 'Tidak dapat menandai Hadir/Terlambat jika anggota tidak melakukan presensi di web. Gunakan Izin atau masukkan waktu check-in secara manual.');
        }

        // Set fields according to chosen status so detail logic recognizes it
        // Use unified status keys ('ontime' / 'late') used by check-in logic
        if ($status === 'hadir') {
            // prefer existing check_in, else use provided check_in, else default
            $ci = $attendance->check_in ?? $request->input('check_in');
            if ($ci) {
                // normalize to H:i:s if only H:i provided
                $parts = explode(':', $ci);
                if (count($parts) === 2) $ci = $ci . ':00';
                $attendance->check_in = $ci;
            } else {
                $attendance->check_in = '07:00:00';
            }
            $attendance->status = 'ontime';
        } elseif ($status === 'terlambat') {
            $ci = $attendance->check_in ?? $request->input('check_in');
            if ($ci) {
                $parts = explode(':', $ci);
                if (count($parts) === 2) $ci = $ci . ':00';
                $attendance->check_in = $ci;
            } else {
                $attendance->check_in = '08:00:00';
            }
            $attendance->status = 'late';
        } elseif ($status === 'izin') {
            $attendance->check_in = null;
            $attendance->status = 'izin';
        } else { // alfa
            $attendance->check_in = null;
            $attendance->status = 'alfa';
        }

        $attendance->save();

        return redirect()->back()->with('success', 'Status presensi diperbarui.');
    }
}