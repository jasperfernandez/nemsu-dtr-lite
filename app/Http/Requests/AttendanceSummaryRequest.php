<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceSummaryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attendance_day_id' => ['required', 'exists:attendance_days'],
            'first_in' => ['required', 'date'],
            'last_out' => ['required', 'date'],
            'late_minutes' => ['required', 'integer'],
            'undertime_minutes' => ['required', 'integer'],
            'work_minutes' => ['required', 'integer'],
            'overtime_minutes' => ['required', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
