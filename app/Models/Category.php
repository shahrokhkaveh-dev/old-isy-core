<?php

namespace App\Models;

use App\Enumerations\Category\Fields;
use App\Enumerations\Table;
use App\Traits\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static whereId(mixed $category)
 * @method static where(string $string, $getAttribute)
 */
class Category extends Model
{
    use HasFactory , Sluggable, HasTranslations;
    protected $table = Table::CATEGORIES->value;

    protected array $translatable = ['name'];
    public function sluggable() : array
    {
        return [
            Fields::SLUG->value => [
                'source' => Fields::NAME->value
            ]
        ];
    }
    protected $fillable = [
        Fields::NAME->value,
        Fields::ENAME->value,
        Fields::SLUG->value,
        Fields::DESCRIPTION->value,
        Fields::ICONS->value,
        Fields::PARENT_ID->value,
        Fields::STATUS->value,
        Fields::ORDER->value,
        Fields::LEVEL->value,
        Fields::CODE->value,
        Fields::IMAGES->value,
        Fields::IMAGE->value
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class , Fields::PARENT_ID->value);
    }

    public function childs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class , Fields::PARENT_ID->value);
    }

    static public function rootCategory(){
        return Category::where(Fields::PARENT_ID->value , null)->get();
    }

    public function isRoot(): bool
    {
        if($this->getAttribute(Fields::PARENT_ID->value) == null){
            return true;
        }
        return false;
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        if($this->isRoot()){
            return $this->hasMany(Product::class , 'category_id');
        }else{
            return $this->hasMany(Product::class , 'sub_category_id');
        }
    }

    public function brands(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Brand::class, 'category_id');
    }
}
