<?php

namespace App\Policies;

use App\Models\DonationCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('donation-categories.view.*');
    }

    public function view(User $user, DonationCategory $category): bool
    {
        return $user->hasPermissionTo('donation-categories.view.*');
    }

    public function create(User $user): bool
    {
        // Only admins can create categories
        return $user->type === 'admin' &&
            $user->hasPermissionTo('donation-categories.create.*');
    }

    public function update(User $user, DonationCategory $category): bool
    {
        // Only admins can update categories
        return $user->type === 'admin' &&
            $user->hasPermissionTo('donation-categories.update.*');
    }

    public function delete(User $user, DonationCategory $category): bool
    {
        // Only admins can delete categories
        return $user->type === 'admin' &&
            $user->hasPermissionTo('donation-categories.delete.*');
    }
}
