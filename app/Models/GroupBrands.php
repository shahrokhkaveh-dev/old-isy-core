<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class GroupBrands extends Model
{
    use HasFactory;

    protected $table = 'group_brands';
    protected $fillable = ['brand_id' , 'group_id'];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
