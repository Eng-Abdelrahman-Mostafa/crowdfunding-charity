<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('users.view.*');
    }

    public function view(User $user, User $model): bool
    {
        // Admin can view all users
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('users.view.*');
        }

        // Association managers can view users related to their associations
        if ($user->type === 'association_manager') {
            // Can view their own profile
            if ($user->id === $model->id) {
                return true;
            }

            // Can view donors who donated to their campaigns
            if ($model->type === 'donor') {
                return $user->hasPermissionTo('users.view.*') &&
                    $user->associations()
                        ->whereHas('campaigns.donations', function($query) use ($model) {
                            $query->where('donor_id', $model->id);
                        })->exists();
            }
        }

        // Donors can only view their own profile
        if ($user->type === 'donor') {
            return $user->id === $model->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        // Only admins can create users
        return $user->type === 'admin' &&
            $user->hasPermissionTo('users.create.*');
    }

    public function update(User $user, User $model): bool
    {
        // Admin can update any user
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('users.update.*');
        }

        // Users can update their own profile
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        // Only admins can delete users
        return $user->type === 'admin' &&
            $user->hasPermissionTo('users.delete.*');
    }

    public function changeStatus(User $user, User $model): bool
    {
        // Only admins can change user status
        return $user->type === 'admin' &&
            $user->hasPermissionTo('users.change-status.*');
    }
}
