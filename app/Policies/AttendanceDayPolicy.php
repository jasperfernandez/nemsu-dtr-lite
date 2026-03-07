<?php

namespace App\Policies;

use App\Models\AttendanceDay;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceDayPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {}

    public function view(User $user, AttendanceDay $attendanceDay) {}

    public function create(User $user) {}

    public function update(User $user, AttendanceDay $attendanceDay) {}

    public function delete(User $user, AttendanceDay $attendanceDay) {}

    public function restore(User $user, AttendanceDay $attendanceDay) {}

    public function forceDelete(User $user, AttendanceDay $attendanceDay) {}
}
