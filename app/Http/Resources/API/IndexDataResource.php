<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'donation_categories' => $this['donation_categories'],
            'counts' => [
                'donation_categories' => $this['donation_categories_count'],
                'associations' => $this['associations_count'],
                'campaigns' => $this['campaigns_count'],
            ],
            'associations' => $this['associations'],
        ];
    }
}
