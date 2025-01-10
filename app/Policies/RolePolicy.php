<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_users');
    }

    public function view(User $user, Role $role): bool
    {
        // Prevent viewing super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('view_users');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_users');
    }

    public function update(User $user, Role $role): bool
    {
        // Prevent updating super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('update_users');
    }

    public function delete(User $user, Role $role): bool
    {
        // Prevent deleting super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('delete_users');
    }

    public function changeStatus(User $user, Role $role): bool
    {
        // Prevent changing status of super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('change_user_status');
    }

    public function restore(User $user, Role $role): bool
    {
        // Prevent restoring super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('restore_users');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        // Prevent force deleting super-admin role
        if ($role->name === 'super-admin') {
            return false;
        }

        return $user->hasPermissionTo('force_delete_users');
    }
}
