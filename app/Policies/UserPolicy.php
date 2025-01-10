<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_users');
    }

    public function view(User $user, User $model): bool
    {
        // Admin can view all users
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('view_users');
        }

        // Association managers can view users related to their associations
        if ($user->type === 'association_manager') {
            // Can view their own profile
            if ($user->id === $model->id) {
                return true;
            }

            // Can view donors who donated to their campaigns
            if ($model->type === 'donor') {
                return $user->hasPermissionTo('view_users') &&
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
        return $user->type === 'admin' && $user->hasPermissionTo('create_users');
    }

    public function update(User $user, User $model): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('update_users');
        }

        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('delete_users');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('restore_users');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('force_delete_users');
    }

    public function changeStatus(User $user, User $model): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('change_user_status');
    }
}
