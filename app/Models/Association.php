<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Association extends Model implements hasMedia
{
    use softDeletes,InteractsWithMedia;
    protected $fillable = [
        'name',
        'description',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'status',//active, inactive
        'created_by',
    ];
    public function getLogoAttribute(): string
    {
        // Check if the media relationship is already loaded
        if ($this->relationLoaded('media') && $this->media->isNotEmpty()) {
            $avatarMedia = $this->media->where('collection_name', 'logo')->first();
            return $avatarMedia ? $avatarMedia->getUrl() : "https://placehold.co/150x150/webp?text=logo";
        }

        // Fallback to the existing method if the media relationship is not loaded
        if ($this->hasMedia('logo')) {
            return $this->getFirstMediaUrl('images');
        }

        // Return default Image from public folder
        return "https://placehold.co/150x150/webp?text=logo";
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }
}
