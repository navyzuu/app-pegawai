<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
        'departemen_id'
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'jabatan_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }
}