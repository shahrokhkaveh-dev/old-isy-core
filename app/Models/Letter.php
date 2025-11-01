<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @method static create(array $array)
 * @method static findOrFail(mixed $id)
 * @method static where(string $string, $brand_id)
 */
class Letter extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'author_id',
        'status',
        'content',
        'is_government',
        'group_name',
        'reciver_name',
        'name',
        'author_name',
    ];

    protected array $translatable = [
        'author_name',
        'reciver_name',
        'name',
        'group_name',
        'content',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($letter) {
            if(auth()->check()){
                $letter->author_name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            }
        });
    }

    public function author(){
        return $this->belongsTo(Brand::class);
    }
    public function attach(){
        $letter =  DB::table('letter_attachments')->where('letter_id' , $this->id)->first();
        if($letter){
            return $letter->attachment;
        }
        return null;
    }

    public function signature()
    {
        $signature = DB::table('letter_signatures')->where('letter_id', $this->id)->first();
        return $signature ? $signature->signature : null;
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'letter_brands');
    }

    public function letter_brands()
    {
        return $this->hasMany(LetterBrand::class);
    }
}
