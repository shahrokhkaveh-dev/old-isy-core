<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 * @method static findOrFail(mixed $decrypt)
 * @method static find(mixed $decrypt)
 * @method static create(array $array)
 */
class Group extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'groups';
    protected $fillable = ['brand_id' , 'name'];
    protected array $translatable = ['name'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function brands(){
        return $this->belongsToMany(Brand::class , 'group_brands');
    }
}
