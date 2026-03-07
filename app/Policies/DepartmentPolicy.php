<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function view(User $user, Department $department): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function update(User $user, Department $department): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->hasRole(Role::HR);
    }

    public function restore(User $user, Department $department) {}

    public function forceDelete(User $user, Department $department) {}
}
