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
        return $user->hasPermissionTo('associations.view.*');
    }

    public function view(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('associations.view.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('associations.view.*') &&
                $association->created_by === $user->id;
        }

        return $user->hasPermissionTo('associations.view.*');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('associations.create.*');
    }

    public function update(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('associations.update.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('associations.update.*') &&
                $association->created_by === $user->id;
        }

        return false;
    }

    public function delete(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('associations.delete.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('associations.delete.*') &&
                $association->created_by === $user->id;
        }

        return false;
    }

    public function changeStatus(User $user, Association $association): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('associations.change-status.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('associations.change-status.*') &&
                $association->created_by === $user->id;
        }

        return false;
    }
}
