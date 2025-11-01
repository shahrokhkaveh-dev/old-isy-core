<?php

namespace App\Models;

use App\Enums\Brand\Fields;
use App\Enums\CommonFields;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipark extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        CommonFields::NAME, CommonFields::PROVINCE_ID, CommonFields::DESCRIPTION
    ];

    protected array $translatable = ['name'];

    public function province()
    {
        return $this->belongsTo(Province::class, CommonFields::PROVINCE_ID);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, Fields::PARK);
    }
}
