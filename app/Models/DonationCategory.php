<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationCategory extends Model
{
    use softDeletes;
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
}
