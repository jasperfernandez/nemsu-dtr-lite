<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'max:50', 'unique:departments,code'],
            'name' => ['required', 'max:255'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
