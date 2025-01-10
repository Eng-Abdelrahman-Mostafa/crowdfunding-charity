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
        return $user->hasPermissionTo('view_donation_categories');
    }

    public function view(User $user, DonationCategory $category): bool
    {
        return $user->hasPermissionTo('view_donation_categories');
    }

    public function create(User $user): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('create_donation_categories');
    }

    public function update(User $user, DonationCategory $category): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('update_donation_categories');
    }

    public function delete(User $user, DonationCategory $category): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('delete_donation_categories');
    }
}
