<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    protected $fillable = [
        'association_id',
        'amount',
        'status',//pending, success, failed
        'note',
        'campaign_id',
        'requested_at',
        'processed_at',
        'requester_id',
        'processor_id',
    ];
    use SoftDeletes;
    public function association()
    {
        return $this->belongsTo(Association::class);
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function processor()
    {
        return $this->belongsTo(User::class, 'processor_id');
    }
}
