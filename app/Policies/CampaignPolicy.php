<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if (!$user->hasPermissionTo('campaigns.view.*')) {
            return false;
        }

        return true;
    }

    public function view(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('campaigns.view.*')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $campaign->association->created_by === $user->id ||
                $campaign->created_by === $user->id;
        }

        return true; // For donors and others, they can view any campaign
    }

    public function create(User $user): bool
    {
        if (!$user->hasPermissionTo('campaigns.create.*')) {
            return false;
        }

        return in_array($user->type, ['admin', 'association_manager']);
    }

    public function update(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('campaigns.update.*')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $campaign->association->created_by === $user->id ||
                $campaign->created_by === $user->id;
        }

        return false;
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('campaigns.delete.*')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $campaign->association->created_by === $user->id ||
                $campaign->created_by === $user->id;
        }

        return false;
    }

    public function restore(User $user, Campaign $campaign): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('campaigns.restore.*');
    }

    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('campaigns.force-delete.*');
    }

    public function changeStatus(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('campaigns.change-status.*')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $campaign->association->created_by === $user->id ||
                $campaign->created_by === $user->id;
        }

        return false;
    }
}
