<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'code',
        'expired_time',
        'used',
    ];

    public function isExpired(){
        return (Carbon::now() > $this->expired_time) ? true : false;
    }
}
