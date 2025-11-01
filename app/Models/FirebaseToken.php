<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'firebase_uid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
