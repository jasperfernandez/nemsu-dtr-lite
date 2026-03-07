<?php

namespace App\Models;

use App\Enums\AttendanceLogSource;
use App\Enums\AttendanceLogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attendance_day_id',
        'employee_id',
        'log_time',
        'type',
        'source',
        'ip_address',
    ];

    public function attendanceDay(): BelongsTo
    {
        return $this->belongsTo(AttendanceDay::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function casts(): array
    {
        return [
            'log_time' => 'datetime',
            'type' => AttendanceLogType::class,
            'source' => AttendanceLogSource::class,
        ];
    }
}
