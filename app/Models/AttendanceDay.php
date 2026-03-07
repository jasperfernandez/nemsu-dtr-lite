<?php

namespace App\Models;

use App\Enums\AttendanceDayStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'work_date',
        'status',
        'remarks',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'status' => AttendanceDayStatus::class,
        ];
    }
}
