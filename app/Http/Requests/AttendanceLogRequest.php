<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceLogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attendance_day_id' => ['required', 'exists:attendance_days'],
            'employee_id' => ['required', 'exists:employees'],
            'log_time' => ['required', 'date'],
            'type' => ['required'],
            'ip_address' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
