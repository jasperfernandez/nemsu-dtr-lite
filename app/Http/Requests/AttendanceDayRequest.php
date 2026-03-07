<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceDayRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_id' => ['nullable', 'exists:employees,id'],
            'work_date' => ['required', 'date'],
            'status' => ['required'],
            'remarks' => ['nullable'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
