<?php

namespace App\Policies;

use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('withdrawals.view.*');
    }

    public function view(User $user, Withdrawal $withdrawal): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('withdrawals.view.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('withdrawals.view.*') &&
                ($withdrawal->association->created_by === $user->id ||
                    $withdrawal->requester_id === $user->id);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('withdrawals.create.*');
    }

    public function update(User $user, Withdrawal $withdrawal): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('withdrawals.update.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('withdrawals.update.*') &&
                ($withdrawal->association->created_by === $user->id ||
                    $withdrawal->requester_id === $user->id);
        }

        return false;
    }

    public function delete(User $user, Withdrawal $withdrawal): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('withdrawals.delete.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('withdrawals.delete.*') &&
                ($withdrawal->association->created_by === $user->id ||
                    $withdrawal->requester_id === $user->id);
        }

        return false;
    }

    public function approve(User $user, Withdrawal $withdrawal): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('withdrawals.approve.*');
    }

    public function reject(User $user, Withdrawal $withdrawal): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('withdrawals.reject.*');
    }
}
