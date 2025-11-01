<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisiong extends Model
{
    use HasFactory;
    protected $table = 'advertisings';
    protected $fillable = [
    'author_id',
    'category_id',
    'title',
    'image_path',
    'box_image_path',
    'content',
    'price',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function author(){
        return $this->belongsTo(Brand::class , 'author_id');
    }
}
