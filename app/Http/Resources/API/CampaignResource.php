<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'goal_amount' => (float) $this->goal_amount,
            'collected_amount' => (float) $this->collected_amount,
            'donation_type' => $this->donation_type,
            'share_amount' => $this->when(
                $this->donation_type === 'share', 
                fn() => (float) $this->share_amount
            ),
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'progress_percentage' => $this->goal_amount > 0 
                ? round(($this->collected_amount / $this->goal_amount) * 100, 2) 
                : 0,
            'donation_category' => [
                'id' => $this->donationCategory->id,
                'name' => $this->donationCategory->name,
            ],
            'association' => [
                'id' => $this->association->id,
                'name' => $this->association->name,
                'logo' => $this->association->logo,
            ],
        ];
    }
}
