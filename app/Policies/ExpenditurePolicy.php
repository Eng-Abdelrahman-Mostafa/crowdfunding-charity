<?php

namespace App\Policies;

use App\Models\Expenditure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenditurePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_expenditures');
    }

    public function view(User $user, Expenditure $expenditure): bool
    {
        if (!$user->hasPermissionTo('view_expenditures')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $expenditure->campaign->association->created_by === $user->id ||
                $expenditure->created_by === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_expenditures');
    }

    public function update(User $user, Expenditure $expenditure): bool
    {
        if (!$user->hasPermissionTo('update_expenditures')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $expenditure->campaign->association->created_by === $user->id ||
                $expenditure->created_by === $user->id;
        }

        return false;
    }

    public function delete(User $user, Expenditure $expenditure): bool
    {
        if (!$user->hasPermissionTo('delete_expenditures')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $expenditure->campaign->association->created_by === $user->id ||
                $expenditure->created_by === $user->id;
        }

        return false;
    }
}
