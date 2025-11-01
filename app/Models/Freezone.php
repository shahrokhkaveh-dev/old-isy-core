<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freezone extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'province_id',
    ];

    protected array $translatable = ['name'];
}
