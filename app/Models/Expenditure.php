<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Expenditure extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'amount',
        'date',
        'campaign_id',
        'created_by',
    ];
    
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
    public function getReceiptAttribute(): string
    {
        // Check if the media relationship is already loaded
        if ($this->relationLoaded('media') && $this->media->isNotEmpty()) {
            $avatarMedia = $this->media->where('collection_name', 'receipt')->first();
            return $avatarMedia ? $avatarMedia->getUrl() : "https://placehold.co/600x450/webp?text=receipt";
        }

        // Fallback to the existing method if the media relationship is not loaded
        if ($this->hasMedia('receipt')) {
            return $this->getFirstMediaUrl('images');
        }

        // Return default Image from public folder
        return "https://placehold.co/600x450/webp?text=receipt";
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('receipt')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }
}
