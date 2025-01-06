<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'address',
        'status',
        'goal_amount',
        'collected_amount',
        'donation_type',
        'share_amount',
        'start_date',
        'end_date',
        'association_id',
        'donation_category_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'goal_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'share_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('userAssociations', function (Builder $builder) {
            if (auth()->check() && auth()->user()->type === 'association_manager') {
                $builder->where(function ($query) {
                    $query->whereHas('association', function ($q) {
                        $q->where('created_by', auth()->id());
                    })
                        ->orWhere('created_by', auth()->id())
                        ->orWhereIn('association_id', auth()->user()->associations->pluck('id'));
                });
            }
        });
    }
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
        return $this->belongsTo(Association::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function donationCategory()
    {
        return $this->belongsTo(DonationCategory::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }
}
