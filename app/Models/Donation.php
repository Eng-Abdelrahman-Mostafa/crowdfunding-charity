<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Donation extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'donor_id',
        'campaign_id',
        'created_by',
        'amount',
        'currency',
        'donate_anonymously',//true, false
        'payment_status',//pending, success, failed
        'payment_method',//online, offline
        'payment_with',//payment gateway, bank, bkash, rocket etc
        'invoice_id',
        'invoice_key',
        'invoice_url',
        'paid_at',
        'due_date',
    ];
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.ms-excel', 'text/plain', 'image/*']);
    }
}
