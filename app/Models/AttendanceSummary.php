<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceSummary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attendance_day_id',
        'first_in',
        'last_out',
        'late_minutes',
        'undertime_minutes',
        'work_minutes',
        'overtime_minutes',
    ];

    public function attendanceDay()
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    protected function casts()
    {
        return [
            'first_in' => 'datetime',
            'last_out' => 'datetime',
        ];
    }
}
