<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\AttendanceDay;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceDayPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::HR) || $user->hasRole(Role::EMPLOYEE);
    }

    public function view(User $user, AttendanceDay $attendanceDay): bool
    {
        if ($user->hasRole(Role::HR)) {
            return true;
        }

        return $user->hasRole(Role::EMPLOYEE)
            && $user->employee?->id === $attendanceDay->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function update(User $user, AttendanceDay $attendanceDay): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function delete(User $user, AttendanceDay $attendanceDay): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function restore(User $user, AttendanceDay $attendanceDay): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function forceDelete(User $user, AttendanceDay $attendanceDay): bool
    {
        return $user->hasRole(Role::HR);
    }
}
