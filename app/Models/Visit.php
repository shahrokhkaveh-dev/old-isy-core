<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'url',
        'user_agent',
    ];

    public function scopeToday($query): Builder
    {
        return $query->whereDate('created_at', today());
    }
}
