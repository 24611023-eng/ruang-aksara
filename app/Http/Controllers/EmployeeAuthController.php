<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class EmployeeAuthController extends Controller
{
    public function showLogin()
    {
        return view('employee.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('employee')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('employee.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }

    public function dashboard(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        $today = now()->toDateString();
        $todayAttendance = $employee ? Attendance::where('employee_id', $employee->id)->where('date', $today)->first() : null;

        $selectedYear = $request->query('year');
        $selectedMonth = $request->query('month');

        $attendanceHistory = collect();
        $availableYears = [];
        if ($employee) {
            $historyQuery = Attendance::where('employee_id', $employee->id);
            if ($selectedYear) {
                $historyQuery->whereYear('date', $selectedYear);
            }
            if ($selectedMonth) {
                $historyQuery->whereMonth('date', $selectedMonth);
            }
            $attendanceHistory = $historyQuery->orderByDesc('date')->get();

            $availableYears = Attendance::where('employee_id', $employee->id)
                ->whereNotNull('date')
                ->selectRaw('YEAR(date) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year')
                ->toArray();
        }

        if (empty($availableYears)) {
            $availableYears = [now()->year];
        }

        // Monthly stats for employee
        $month = now()->month;
        $year = now()->year;

        $monthlyStats = null;
        if ($employee) {
            $monthlyStats = Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->selectRaw('COUNT(*) as total_days, SUM(CASE WHEN status = "ontime" THEN 1 ELSE 0 END) as ontime_days, SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_days, SUM(CASE WHEN check_in IS NULL THEN 1 ELSE 0 END) as absent_days')
                ->first();
        }

        return view('attendance.dashboard', [
            'todayAttendance' => $todayAttendance,
            'monthlyStats' => $monthlyStats,
            'employee' => $employee,
            'attendanceHistory' => $attendanceHistory,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
        ]);
    }

    public function profile()
    {
        $employee = Auth::guard('employee')->user();
        return view('employee.profile', compact('employee'));
    }

    public function update(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        $request->validate([
            'name' => ["required","string","max:255","regex:/^[\p{L}\s\.\-']+$/u"],
            'telepon' => ['required','string','max:20','regex:/^(\+62|0)[0-9]{7,12}$/'],
            'tanggal_lahir' => 'nullable|date',
            'nik' => ['required','digits:16'],
            'new_password' => ['nullable','string','min:8','confirmed']
        ], [
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf, spasi, titik, tanda hubung, atau kutip tunggal.',
            'telepon.regex' => 'Format telepon tidak valid. Mulai dengan +62 atau 0 dan diikuti 8–13 angka.',
            'nik.digits' => 'NIK harus berisi 16 angka.',
        ]);

        $nameChanged = $request->input('name') !== $employee->name;
        $teleponChanged = $request->input('telepon') !== ($employee->telepon ?? '');
        $tanggalLahirChanged = $request->input('tanggal_lahir') !== ($employee->tanggal_lahir ? $employee->tanggal_lahir->format('Y-m-d') : '');
        $nikChanged = $request->input('nik') !== ($employee->nik ?? '');

        if ($nameChanged || $teleponChanged || $tanggalLahirChanged || $nikChanged) {
            $request->validate([
                'current_password' => 'required|string'
            ], [
                'current_password.required' => 'Password saat ini diperlukan untuk menyimpan perubahan',
            ]);

            if (!\Hash::check($request->current_password, $employee->password)) {
                return redirect()->route('employee.profile')->with('error', 'Password saat ini tidak sesuai!');
            }
        }

        $employee->update($request->only('name', 'telepon', 'tanggal_lahir', 'nik'));

        if ($request->filled('new_password')) {
            $employee->password = \Hash::make($request->new_password);
            $employee->save();
        }

        return redirect()->route('employee.profile')->with('success', 'Profil pegawai berhasil diperbarui.');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $employee = Auth::guard('employee')->user();

        if ($employee->foto_profil) {
            try { \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->foto_profil); } catch (\Exception $e) { }
        }

        $path = $request->file('foto_profil')->store('employee-profile-pictures', 'public');
        $employee->foto_profil = $path;
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Foto profil pegawai berhasil diperbarui!', 'path' => $path]);
    }
}
