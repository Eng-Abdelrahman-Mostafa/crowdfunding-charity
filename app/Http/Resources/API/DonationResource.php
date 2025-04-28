<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $anonymousLabel = __('messages.anonymous_donor');
        $paidAtParsed = $this->paid_at ? Carbon::parse($this->paid_at)->format('Y-m-d H:i:s'):null;
        return [
            'id' => $this->id,
            'donor' => [
                'id' => $this->donor_id,
                'name' => $this->donate_anonymously ? $anonymousLabel : $this->donor->name,
            ],
            'campaign' => [
                'id' => $this->campaign_id,
                'name' => $this->campaign->name,
            ],
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'is_anonymous' => (bool) $this->donate_anonymously,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'payment_with' => $this->payment_with,
            'paid_at' => $paidAtParsed ,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
