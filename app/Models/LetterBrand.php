<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterBrand extends Model
{
    use HasFactory;
    protected $table = 'letter_brands';
    protected $fillable = ['letter_id' , 'brand_id' , 'status' , 'seen'];

    public function letter(){
        return $this->belongsTo(Letter::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
