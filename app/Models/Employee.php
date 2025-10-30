<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'departemen_id',
        'jabatan_id',     
        'status'
    ];

   
    public function department()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }

    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class, 'karyawan_id')->whereDate('tanggal', today());
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'karyawan_id');
    }
}