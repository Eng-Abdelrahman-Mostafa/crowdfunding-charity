<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_donations');
    }

    public function view(User $user, Donation $donation): bool
    {
        if (!$user->hasPermissionTo('view_donations')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $donation->campaign->association->created_by === $user->id;
        }

        // Donors can only view their own donations
        if ($user->type === 'donor') {
            return $donation->donor_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_donations');
    }

    public function changeStatus(User $user, Donation $donation): bool
    {
        if (!$user->hasPermissionTo('change_donation_status')) {
            return false;
        }

        if ($user->type === 'admin') {
            return true;
        }

        if ($user->type === 'association_manager') {
            return $donation->campaign->association->created_by === $user->id;
        }

        return false;
    }
}
