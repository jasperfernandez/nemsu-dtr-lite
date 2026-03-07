<?php

namespace App\Http\Requests;

use App\Enums\EmployeeStatus;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Employee|null $employee */
        $employee = $this->route('employee');

        return [
            'email' => [
                Rule::when(! $employee, ['required', 'email', Rule::unique('users', 'email')]),
                Rule::when(
                    (bool) $employee,
                    ['sometimes', 'email', Rule::unique('users', 'email')->ignore($employee?->user_id)]
                ),
            ],
            'employee_number' => [
                'required',
                Rule::unique('employees', 'employee_number')->ignore($employee?->id),
            ],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position' => ['nullable', 'max:50'],
            'status' => ['required', Rule::enum(EmployeeStatus::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
