<?php

namespace App\Models\Admin;

use App\Enums\AdminLoginAttempt\Fields;
use App\Enums\CommonFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        CommonFields::USERNAME, Fields::IP, Fields::AGENT, Fields::REFERRER, Fields::STATUS
    ];
}
