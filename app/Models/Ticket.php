<?php

namespace App\Models;

use App\Enums\Ticket\Entries;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'brand_id',
        'department',
        'status',
        'priority',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function getStatusAttribute($value)
    {
        return Entries::STATUS[$value];
    }

    public function getUpdatedAtAttribute($value)
    {
        return jdate($value)->format('Y/m/d');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }
}
