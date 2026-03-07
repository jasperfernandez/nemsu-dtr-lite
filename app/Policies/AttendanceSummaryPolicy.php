<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\AttendanceSummary;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceSummaryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::HR) || $user->hasRole(Role::EMPLOYEE);
    }

    public function view(User $user, AttendanceSummary $attendanceSummary): bool
    {
        if ($user->hasRole(Role::HR)) {
            return true;
        }

        return $user->hasRole(Role::EMPLOYEE)
            && $user->employee?->id === $attendanceSummary->attendanceDay?->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function update(User $user, AttendanceSummary $attendanceSummary): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function delete(User $user, AttendanceSummary $attendanceSummary): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function restore(User $user, AttendanceSummary $attendanceSummary): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function forceDelete(User $user, AttendanceSummary $attendanceSummary): bool
    {
        return $user->hasRole(Role::HR);
    }
}
