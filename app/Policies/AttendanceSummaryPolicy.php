<?php

namespace App\Policies;

use App\Models\AttendanceSummary;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceSummaryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {}

    public function view(User $user, AttendanceSummary $attendanceSummary) {}

    public function create(User $user) {}

    public function update(User $user, AttendanceSummary $attendanceSummary) {}

    public function delete(User $user, AttendanceSummary $attendanceSummary) {}

    public function restore(User $user, AttendanceSummary $attendanceSummary) {}

    public function forceDelete(User $user, AttendanceSummary $attendanceSummary) {}
}
