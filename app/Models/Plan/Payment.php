<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'plan_payments';

    protected $fillable = [
        'plan_id',
        'brand_id',
        'amount',
        'refrence_code',
        'status',
    ];
}
