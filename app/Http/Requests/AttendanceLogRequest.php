<?php

namespace App\Http\Requests;

use App\Enums\AttendanceLogSource;
use App\Enums\AttendanceLogType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceLogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attendance_day_id' => ['required', 'exists:attendance_days,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'log_time' => ['required', 'date'],
            'type' => ['required', Rule::enum(AttendanceLogType::class)],
            'source' => ['required', Rule::enum(AttendanceLogSource::class)],
            'ip_address' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
