<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DetailedCampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = App::getLocale();
        $anonymousLabel = $locale === 'ar' ? 'متبرع مجهول' : 'Anonymous Donor';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'address' => $this->address,
            'goal_amount' => (float) $this->goal_amount,
            'collected_amount' => (float) $this->collected_amount,
            'available_balance' => (float) $this->getAvailableBalance(),
            'donation_type' => $this->donation_type,
            'share_amount' => $this->when(
                $this->donation_type === 'share', 
                fn() => (float) $this->share_amount
            ),
            'status' => $this->status,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'progress_percentage' => $this->goal_amount > 0 
                ? round(($this->collected_amount / $this->goal_amount) * 100, 2) 
                : 0,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'donation_category' => [
                'id' => $this->donationCategory->id,
                'name' => $this->donationCategory->name,
            ],
            'association' => [
                'id' => $this->association->id,
                'name' => $this->association->name,
                'logo' => $this->association->logo,
                'website' => $this->association->website,
                'email' => $this->association->email,
                'phone' => $this->association->phone,
            ],
            'creator' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'recent_donations' => $this->whenLoaded('donations', function () use ($anonymousLabel) {
                return $this->donations
                    ->where('payment_status', 'success')
                    ->sortByDesc('created_at')
                    ->take(5)
                    ->map(function ($donation) use ($anonymousLabel) {
                        return [
                            'id' => $donation->id,
                            'donor_name' => $donation->donate_anonymously ? $anonymousLabel : $donation->donor->name,
                            'amount' => (float) $donation->amount,
                            'created_at' => $donation->created_at->format('Y-m-d H:i:s'),
                            'is_anonymous' => (bool) $donation->donate_anonymously,
                        ];
                    })
                    ->values();
            }),
            'total_donations_count' => $this->whenCounted('donations', function () {
                return $this->donations->where('payment_status', 'success')->count();
            }),
            'expenditures' => $this->whenLoaded('expenditures', function () {
                return $this->expenditures
                    ->sortByDesc('date')
                    ->map(function ($expenditure) {
                        return [
                            'id' => $expenditure->id,
                            'name' => $expenditure->name,
                            'amount' => (float) $expenditure->amount,
                            'date' => $expenditure->date->format('Y-m-d'),
                        ];
                    })
                    ->values();
            }),
            'total_expenditures_amount' => $this->whenLoaded('expenditures', function () {
                return (float) $this->expenditures->sum('amount');
            }),
        ];
    }
}
