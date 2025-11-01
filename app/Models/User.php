<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasTranslations;

    protected array $translatable = ['first_name', 'last_name', 'name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'email_verified_at',
        'phone_verified_at',
        'province_id',
        'city_id',
        'address',
        'is_active',
        'status',
        'is_foreign_account',
        'is_admin',
        'is_branding',
        'brand_id',
        'otp',
        'otp_expired_time',
        'birthday',
        'nationality_code',
        'avatar',
        'identification_code',
        'referral_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user){
            $user->referral_code = self::generateUniqueReferralCode();
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function province()
    {
        $item = Province::find($this->province_id);
        return $item->name;
    }

    public function city()
    {
        $item = City::find($this->city_id);
        return $item->name;
    }

    public function status()
    {
        $array = [
            1 => 'فعال',
        ];
        return $array[$this->status];
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_role')->using(UserRole::class);
    // }

    public function permissions() : BelongsToMany {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'owner_id', 'id');
    }

    public function Groups()
    {
        return $this->hasMany(Group::class, 'owner_id');
    }

    public function access($code)
    {
        $record = DB::table('user_permissions')->where(['user_id' => $this->id, 'permission_id' => $code])->first();
        return $record ? true : false;
    }

    public function signature()
    {
        return $this->hasOne(Signature::class);
    }

    public function ability()
    {
        $ability = DB::table('user_permissions')->where('user_id', '=', $this->id)->select(('permission_id'));

        if ($ability->exists()) {
            $ability = $ability->get()->toArray();
            $ability = array_column($ability, 'permission_id');
            return $ability;
        }

        return [];
    }

    public function firebaseToken()
    {
        return $this->hasOne(FirebaseToken::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(UserReferral::class, 'referrer_user_id');
    }

    public function refferedBy(): HasMany
    {
        return $this->hasMany(UserReferral::class, 'referred_user_id');
    }

    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, Wishlist::class, 'user_id', 'product_id');
    }

    // Functions
    private static function generateUniqueReferralCode(int $length = 8): ?string
    {
        do {
            $code = strtoupper(Str::random($length));
        }while(self::where('referral_code', $code)->exists());

        return $code;
    }

    // check
    public function hasReferrer()
    {
        return $this->referredBy()->exists();
    }
    public function getReferrer()
    {
        return $this->referredBy()->first()?->referrer;
    }

    public function myBrand(): HasOne
    {
        return $this->hasOne(Brand::class, 'manager_id');
    }
}
