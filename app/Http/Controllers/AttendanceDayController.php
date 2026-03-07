<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceDayResource;
use App\Http\Resources\EmployeeResource;
use App\Enums\Role;
use App\Models\AttendanceDay;
use App\Models\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class AttendanceDayController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', AttendanceDay::class);

        $user = auth()->user();

        $attendanceDays = AttendanceDay::with(['employee', 'attendanceLogs'])
            ->latest('work_date')
            ->when(! $user->hasRole(Role::HR), fn ($q) => $q->where('employee_id', $user->employee?->id))
            ->get();

        return Inertia::render('attendance-days/Index', [
            'attendanceDays' => AttendanceDayResource::collection($attendanceDays),
            'isHr' => $user->hasRole(Role::EMPLOYEE),
            'employees' => $user->hasRole(Role::HR)
                ? EmployeeResource::collection(Employee::all())
                : [],
        ]);
    }

    public function destroy(AttendanceDay $attendanceDay)
    {
        $this->authorize('delete', $attendanceDay);

        $attendanceDay->attendanceLogs()->delete();
        $attendanceDay->delete();

        return redirect()->route('attendance_days.index')->with('success', 'Attendance day and logs deleted successfully.');
    }
}
