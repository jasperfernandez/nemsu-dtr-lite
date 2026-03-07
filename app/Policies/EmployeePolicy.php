<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function restore(User $user, Employee $employee): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->hasRole(Role::HR);
    }
}
