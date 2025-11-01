<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReferral extends Model
{
    protected $fillable = [
        'referrer_user_id',
        'referred_user_id',
        'referrer_brand_id',
        'referred_brand_id',
        'claimed_at'
    ];

    protected $dates = ['claimed_at'];

    // Relations
    public function referrerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }
    public function referredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
    public function referrerBrand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'referrer_brand_id');
    }
    public function referredBrand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'referred_brand_id');
    }
    public function isClaimed()
    {
        return !is_null($this->claimed_at);
    }
}
