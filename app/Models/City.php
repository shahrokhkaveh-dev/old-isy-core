<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'cities';
    protected $fillable = ['name' , 'province_id' , 'latitude' , 'longitude' , 'phi' , 'landa'];
    protected array $translatable = ['name'];

    public function province(){
        return $this->belongsTo(Province::class , 'province_id');
    }
}
