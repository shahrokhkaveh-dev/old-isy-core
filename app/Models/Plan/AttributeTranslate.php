<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeTranslate extends Model
{
    use HasFactory;

    protected $table = 'plan_attribute_translates';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
