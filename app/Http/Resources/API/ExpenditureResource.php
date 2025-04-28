<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenditureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dateParsed=$this->date?Carbon::parse($this->date)->format('Y-m-d'): null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'amount' => (float) $this->amount,
            'date' => $dateParsed,
            'receipt' => $this->receipt,
            'campaign' => [
                'id' => $this->campaign_id,
                'name' => $this->campaign->name,
            ],
            'creator' => [
                'id' => $this->created_by,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
