<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class LinkEmployeeController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Split name into first and last
        $nameParts = explode(' ', $user->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        return Inertia::render('LinkEmployee', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'departments' => DepartmentResource::collection(Department::all()),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => ['required', Rule::unique('employees', 'employee_number')],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position' => ['nullable', 'max:50'],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
        ]);

        $user = Auth::user();

        Employee::create([
            'user_id' => $user->id,
            'employee_number' => $validated['employee_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department_id' => $validated['department_id'] ?? null,
            'position' => $validated['position'] ?? null,
            'status' => 'active',
        ]);

        $user->assignRole(Role::EMPLOYEE);

        return redirect()->route('dashboard')->with('success', 'Employee profile linked successfully.');
    }
}

