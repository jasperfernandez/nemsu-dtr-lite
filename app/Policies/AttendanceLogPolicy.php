<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::HR) || $user->hasRole(Role::EMPLOYEE);
    }

    public function view(User $user, AttendanceLog $attendanceLog): bool
    {
        if ($user->hasRole(Role::HR)) {
            return true;
        }

        return $user->hasRole(Role::EMPLOYEE)
            && $user->employee?->id === $attendanceLog->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function update(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function delete(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function restore(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function forceDelete(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->hasRole(Role::HR);
    }
}
