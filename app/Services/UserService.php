<?php

namespace App\Services;

use App\Models\User;
use App\Http\Filters\UserFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function list(array $filters = [], bool $trashed = false): LengthAwarePaginator
    {
        $query = User::query();

        if ($trashed) {
            $query->onlyTrashed();
        }

        return QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('search', new UserFilter),
                AllowedFilter::custom('type', new UserFilter),
                AllowedFilter::custom('status', new UserFilter),
                AllowedFilter::custom('created_at', new UserFilter),
                AllowedFilter::custom('updated_at', new UserFilter),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['name', 'email', 'created_at', 'updated_at'])
            ->paginate(request()->input('per_page', 15))
            ->withQueryString();
    }

    public function toggleStatus(User $user): User
    {
        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
        } else {
            $user->update(['email_verified_at' => now()]);
        }

        return $user->fresh();
    }

    public function restore(User $user): bool
    {
        return $user->restore();
    }
}
