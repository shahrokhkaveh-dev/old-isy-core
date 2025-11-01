<?php

namespace App\Models;

use App\Enums\CommonEntries;
use App\Models\Admin\Admin;
use App\Models\Admin\RejectionReason;
use App\Traits\HasTranslations;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find(mixed $decrypt)
 * @method static findOrFail(mixed $decrypt)
 * @method static select(string[] $array)
 */
class Brand extends Model
{
    use HasFactory , Sluggable, HasTranslations;

    protected $fillable = [
        'personels_count', 'province_id', 'city_id','ipark_id','freezone_id', 'name', 'nationality_code', 'economic_code',
        'register_code', 'license_number', 'phone_number', 'post_code', 'address', 'logo_path', 'is_active', 'status',
        'slug', 'url', 'category_id', 'managment_name', 'managment_profile_path', 'managment_number',
        'managment_position', 'description', 'identification_code', 'reviewed_by','vip_expired_time'
    ];

    protected array $translatable = [
        'address',
        'description',
        'managment_name',
        'managment_position',
        'name',
        'plan_name'
    ];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function ipark(){
        return $this->belongsTo(Ipark::class);
    }

    public function freezone(){
        return $this->belongsTo(Freezone::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function personels(){
        return $this->hasMany(Personel::class);
    }

    public function productInquries(){
        return $this->hasMany(ProductInquery::class , 'destination_id');
    }

    public function letters(){
        return $this->belongsToMany(Letter::class , 'letter_brands');
    }

    public function brandImages()
    {
        return $this->hasMany(BrandImage::class);
    }

    public function isVip(){
        return $this->vip_expired_time > Carbon::now();
    }

    public function status(){
        $st = [
            1=>'در انتظار ارسال مدارک',
        ];
        return $st[$this->status];
    }
    public function document(){
        return $this->hasOne(Document::class);
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

    public function users(){
        return $this->hasMany(User::class);
    }

    public function brandType(){
        return $this->belongsTo(BrandType::class, 'type', 'id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(UserReferral::class, 'referrer_brand_id');
    }
    public function refferedBy(): HasMany
    {
        return $this->hasMany(UserReferral::class, 'referred_brand_id');
    }
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
