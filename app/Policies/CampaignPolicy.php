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
        return $user->hasPermissionTo('view_campaigns');
    }

    public function view(User $user, Campaign $campaign): bool
    {
        return $user->hasPermissionTo('view_campaigns');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_campaigns');
    }

    public function update(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('update_campaigns')) {
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
        if (!$user->hasPermissionTo('delete_campaigns')) {
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
        return $user->type === 'admin' && $user->hasPermissionTo('restore_campaigns');
    }

    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return $user->type === 'admin' && $user->hasPermissionTo('force_delete_campaigns');
    }

    public function changeStatus(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('change_campaign_status')) {
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

    public function publish(User $user, Campaign $campaign): bool
    {
        if (!$user->hasPermissionTo('publish_campaigns')) {
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
