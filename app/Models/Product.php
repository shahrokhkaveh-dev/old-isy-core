<?php

namespace App\Models;

use App\Enums\CommonEntries;
use App\Models\Admin\Admin;
use App\Models\Admin\RejectionReason;
use App\Traits\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , Sluggable , SoftDeletes, HasTranslations;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'ename',
        'image',
        'slug',
        'description',
        'status',
        'warranty',
        'category_id',
        'unit',
        'score',
        'votes',
        'excerpt',
        'brand_id',
        'isExportable',
        'HSCode',
        'reviewed_by',
    ];

    // protected $hidden = ['id'];

    protected array $translatable = ['description', 'excerpt', 'name'];

    // public function sub_category(){
    //     return $this->belongsTo(Category::class , 'sub_category_id');
    // }
    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(Category::class , 'sub_category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function inqueries(){
        return $this->hasMany(ProductInquery::class);
    }

    public function attributes(){
        return $this->hasMany(ProductAttributes::class);
    }

    public function city(){
        return $this->belongsTo(City::class , 'city_id');
    }
    public function province(){
        return $this->belongsTo(Province::class , 'province_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviewedBy(){
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function rejectionReasons(){
        return $this->morphMany(RejectionReason::class, 'describable');
    }

    public function getStatusAttribute($statusEntry){
        if($statusEntry == CommonEntries::PENDING_STATUS){
            return CommonEntries::PENDING_OUTPUT;
        } elseif ($statusEntry == CommonEntries::REJECTED_STATUS){
            return CommonEntries::REJECTED_OUTPUT;
        } elseif ($statusEntry == CommonEntries::CONFIRMED_STATUS){
            return CommonEntries::CONFIRMED_OUTPUT;
        }

        return $statusEntry;
    }
}
