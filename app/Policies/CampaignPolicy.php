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
        return $user->hasPermissionTo('campaigns.view.*');
    }

    public function view(User $user, Campaign $campaign): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('campaigns.view.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('campaigns.view.*') &&
                ($campaign->association->created_by === $user->id ||
                    $campaign->created_by === $user->id);
        }

        return $user->hasPermissionTo('campaigns.view.*');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('campaigns.create.*');
    }

    public function update(User $user, Campaign $campaign): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('campaigns.update.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('campaigns.update.*') &&
                ($campaign->association->created_by === $user->id ||
                    $campaign->created_by === $user->id);
        }

        return false;
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('campaigns.delete.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('campaigns.delete.*') &&
                ($campaign->association->created_by === $user->id ||
                    $campaign->created_by === $user->id);
        }

        return false;
    }

    public function publish(User $user, Campaign $campaign): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('campaigns.publish.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('campaigns.publish.*') &&
                ($campaign->association->created_by === $user->id ||
                    $campaign->created_by === $user->id);
        }

        return false;
    }

    public function changeStatus(User $user, Campaign $campaign): bool
    {
        if ($user->type === 'admin') {
            return $user->hasPermissionTo('campaigns.change-status.*');
        }

        if ($user->type === 'association_manager') {
            return $user->hasPermissionTo('campaigns.change-status.*') &&
                ($campaign->association->created_by === $user->id ||
                    $campaign->created_by === $user->id);
        }

        return false;
    }
}
