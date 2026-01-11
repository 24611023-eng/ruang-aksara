<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'telepon',
        'notes',
        'nik',
        'tanggal_lahir',
        'foto_profil'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relation to attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
