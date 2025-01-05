<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return match($property) {
            'search' => $query->where(function($query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }),
            'type' => $query->where('type', $value),
            'status' => $query->when($value === 'active',
                fn($q) => $q->whereNotNull('email_verified_at'),
                fn($q) => $q->whereNull('email_verified_at')
            ),
            'created_at' => $query->whereBetween('created_at', [
                $value['from'] ?? now()->subYears(10),
                $value['to'] ?? now()
            ]),
            'updated_at' => $query->whereBetween('updated_at', [
                $value['from'] ?? now()->subYears(10),
                $value['to'] ?? now()
            ]),
            default => $query
        };
    }
}
