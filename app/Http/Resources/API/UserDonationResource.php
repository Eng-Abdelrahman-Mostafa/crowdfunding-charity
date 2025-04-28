<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paidAtParsed = null;
        if ($this->paid_at) {
            try {
                $paidAtParsed = $this->paid_at instanceof \Carbon\Carbon
                    ? $this->paid_at->format('Y-m-d H:i:s')
                    : Carbon::parse($this->paid_at)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // If parsing fails, just return the raw value
                $paidAtParsed = $this->paid_at;
            }
        }
        
        return [
            'id' => $this->id,
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'payment_with' => $this->payment_with,
            'is_anonymous' => (bool) $this->donate_anonymously,
            'paid_at' => $paidAtParsed,
            'created_at' => $this->created_at instanceof \Carbon\Carbon
                ? $this->created_at->format('Y-m-d H:i:s')
                : (is_string($this->created_at) ? $this->created_at : null),
            'campaign' => $this->whenLoaded('campaign', function() {
                return [
                    'id' => $this->campaign->id,
                    'name' => $this->campaign->name,
                    'thumbnail' => $this->campaign->thumbnail,
                    'donation_type' => $this->campaign->donation_type,
                    'share_amount' => $this->campaign->donation_type === 'share' ? (float) $this->campaign->share_amount : null,
                    'association' => $this->whenLoaded('campaign.association', function() {
                        return [
                            'id' => $this->campaign->association->id,
                            'name' => $this->campaign->association->name,
                            'logo' => $this->campaign->association->logo,
                        ];
                    }),
                    'category' => $this->whenLoaded('campaign.donationCategory', function() {
                        return [
                            'id' => $this->campaign->donationCategory->id,
                            'name' => $this->campaign->donationCategory->name,
                        ];
                    })
                ];
            }, [
                'id' => $this->campaign_id,
            ]),
            'invoice_url' => $this->whenNotNull($this->invoice_url),
        ];
    }
}
