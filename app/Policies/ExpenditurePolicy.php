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
        return $user->hasPermissionTo('expenditures.view.*');
    }

    public function view(User $user, Expenditure $expenditure): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('expenditures.view.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('expenditures.view.*') &&
                ($expenditure->campaign->association->created_by === $user->id ||
                    $expenditure->created_by === $user->id);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('expenditures.create.*');
    }

    public function update(User $user, Expenditure $expenditure): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('expenditures.update.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('expenditures.update.*') &&
                ($expenditure->campaign->association->created_by === $user->id ||
                    $expenditure->created_by === $user->id);
        }

        return false;
    }

    public function delete(User $user, Expenditure $expenditure): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('expenditures.delete.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('expenditures.delete.*') &&
                ($expenditure->campaign->association->created_by === $user->id ||
                    $expenditure->created_by === $user->id);
        }

        return false;
    }
}
