<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'employee_number' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'department_id' => ['nullable', 'exists:departments'],
            'position' => ['required'],
            'status' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
