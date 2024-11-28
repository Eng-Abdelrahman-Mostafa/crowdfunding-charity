<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements hasMedia
{
    use InteractsWithMedia,softDeletes;
    protected $fillable = [
        'name',
        'description',
        'address',
        'status',//active, inactive
        'goal_amount',
        'collected_amount',
        'donation_type',//open,share
        'share_amount',
        'start_date',
        'end_date',
        'association_id',
        'donation_category_id',
        'created_by',
    ];
    public function getThumbnailAttribute(): string
    {
        // Check if the media relationship is already loaded
        if ($this->relationLoaded('media') && $this->media->isNotEmpty()) {
            $avatarMedia = $this->media->where('collection_name', 'thumbnail')->first();
            return $avatarMedia ? $avatarMedia->getUrl() : "https://placehold.co/600x450/webp?text=thumbnail";
        }

        // Fallback to the existing method if the media relationship is not loaded
        if ($this->hasMedia('thumbnail')) {
            return $this->getFirstMediaUrl('images');
        }

        // Return default Image from public folder
        return "https://placehold.co/600x450/webp?text=thumbnail";
    }
    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function donationCategory()
    {
        return $this->belongsTo(DonationCategory::class, 'donation_category_id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }
}
