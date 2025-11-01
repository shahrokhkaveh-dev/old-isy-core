<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInquery extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'product_inquiries';
    protected $fillable = [
        'author_id',
        'product_id',
        'brand_id',
        'destination_id',
        'number',
        'description',
        'status',
        'amount',
        'response_description',
        'response_date',
        'prefactor_path',
        'unit',
        'max_budget'
    ];
    protected array $translatable = ['description', 'response_description', 'unit'];
    protected string $translationModel = ProductInquiryTranslate::class;
    protected string $translationForeignKey = 'product_inquiry_id';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
     public function responser()
    {
        return $this->belongsTo(User::class, 'responser_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function status()
    {
        switch ($this->status) {
            case 1:
                return 'در انتظار پاسخ';
            case 2:
                return 'تایید شده';
            case 3:
                return 'رد شده';
        }
    }
    public function destination()
    {
        return $this->belongsTo(Brand::class, 'destination_id');
    }
}
