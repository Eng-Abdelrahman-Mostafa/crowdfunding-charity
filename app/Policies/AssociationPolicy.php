<?php

namespace App\Policies;

use App\Models\Association;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssociationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_associations');
    }

    public function view(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('view_associations');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('view_associations') &&
                $association->created_by === $user->id;
        }

        return $user->hasPermissionTo('view_associations');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_associations');
    }

    public function update(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('update_associations');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('update_associations') &&
                $association->created_by === $user->id;
        }

        return false;
    }

    public function delete(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('delete_associations');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('delete_associations') &&
                $association->created_by === $user->id;
        }

        return false;
    }

    public function changeStatus(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('change_association_status');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('change_association_status') &&
                $association->created_by === $user->id;
        }

        return false;
    }
}
