<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerEmployeeController extends Controller
{
    public function __construct()
    {
        // controller digunakan oleh owner saja via routes middleware
    }

    public function index()
    {
        $employees = Employee::orderBy('name')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.employees.index')->with('error', 'Gagal menghapus pegawai: ' . $e->getMessage());
        }
    }
}
