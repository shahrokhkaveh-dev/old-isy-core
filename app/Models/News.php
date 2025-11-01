<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table='news';
    protected $fillable = ['author_id',	'category_id',	'title',	'image_path',	'box_image_path',	'content'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function author(){
        return $this->belongsTo(Brand::class , 'author_id');
    }

}
