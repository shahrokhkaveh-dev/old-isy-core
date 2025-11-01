<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = ['name'];
    protected $table = 'provinces';
    protected array $translatable = ['name'];

    public function cities(){
        return $this->hasMany(City::class , 'province_id');
    }
}
