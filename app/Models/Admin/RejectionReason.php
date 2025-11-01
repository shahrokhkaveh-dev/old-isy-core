<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'describable_type', 'describable_id', 'description'
    ];

    public function describable(){
        return $this->morphTo();
    }
}
