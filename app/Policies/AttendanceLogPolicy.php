<?php

namespace App\Policies;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {}

    public function view(User $user, AttendanceLog $attendanceLog) {}

    public function create(User $user) {}

    public function update(User $user, AttendanceLog $attendanceLog) {}

    public function delete(User $user, AttendanceLog $attendanceLog) {}

    public function restore(User $user, AttendanceLog $attendanceLog) {}

    public function forceDelete(User $user, AttendanceLog $attendanceLog) {}
}
