<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi',
                'password' => Hash::make('password123'),
                'position' => 'Staff',
                'telepon' => '',
                'notes' => 'Pegawai otomatis dibuat'
            ]
        );
    }
}
