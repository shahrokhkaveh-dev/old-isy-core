<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'product_attributes';
    protected $fillable = ['product_id',	'name',	'value'];
    protected string $translationModel = ProductAttributeTranslate::class;
    protected array $translatable = ['name', 'value'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
