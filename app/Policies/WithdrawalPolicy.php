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
        return $user->hasPermissionTo('view_withdrawals');
    }

    public function view(User $user, Withdrawal $withdrawal): bool
    {
        if (!$user->hasPermissionTo('view_withdrawals')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $withdrawal->association->created_by === $user->id ||
                $withdrawal->requester_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_withdrawals');
    }

    public function update(User $user, Withdrawal $withdrawal): bool
    {
        if (!$user->hasPermissionTo('update_withdrawals')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $withdrawal->association->created_by === $user->id ||
                $withdrawal->requester_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Withdrawal $withdrawal): bool
    {
        if (!$user->hasPermissionTo('delete_withdrawals')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $withdrawal->association->created_by === $user->id ||
                $withdrawal->requester_id === $user->id;
        }

        return false;
    }

    public function approve(User $user, Withdrawal $withdrawal): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('approve_withdrawals');
    }

    public function reject(User $user, Withdrawal $withdrawal): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('reject_withdrawals');
    }
}
