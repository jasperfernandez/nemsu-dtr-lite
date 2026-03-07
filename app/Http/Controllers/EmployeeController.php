<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeWelcomeNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Employee::class);

        return Inertia::render('employees/Index', [
            'employees' => EmployeeResource::collection(Employee::with(['department', 'user:id,email'])->get()),
            'departments' => DepartmentResource::collection(Department::all()),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $this->authorize('create', Employee::class);

        $validated = $request->validated();

        $password = Str::password(12);

        $user = User::create([
            'name' => $validated['first_name'].' '.$validated['last_name'],
            'email' => $validated['email'],
            'password' => $password,
        ]);

        $user->assignRole(Role::EMPLOYEE);

        $user->notify(new EmployeeWelcomeNotification($password));

        Employee::create([
            'user_id' => $user->id,
            'employee_number' => $validated['employee_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department_id' => $validated['department_id'] ?? null,
            'position' => $validated['position'] ?? null,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Employee added successfully.');
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validated();

        $employee->update([
            'employee_number' => $validated['employee_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department_id' => $validated['department_id'] ?? null,
            'position' => $validated['position'] ?? null,
            'status' => $validated['status'],
        ]);

        if (isset($validated['email'])) {
            $employee->user->update(['email' => $validated['email']]);
        }

        return back()->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();

        return back()->with('success', 'Employee deleted successfully.');
    }
}
