<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {}

    public function view(User $user, Employee $employee) {}

    public function create(User $user) {}

    public function update(User $user, Employee $employee) {}

    public function delete(User $user, Employee $employee) {}

    public function restore(User $user, Employee $employee) {}

    public function forceDelete(User $user, Employee $employee) {}
}
