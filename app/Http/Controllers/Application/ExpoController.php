<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Application\ApplicationService;

class ExpoController extends Controller
{
    // public function brands()
    // {
    //     // تعریف کوئری
    //     $query = Brand::query()
    //     ->with(['province:id,name', 'city:id,name', 'ipark:id,name', 'freezone:id,name','category:id,name','brandType:id,name'])
    //     ->latest()->select([
    //         'brands.id',
    //         'brands.vip_expired_time',
    //         'brands.name',
    //         'brands.logo_path',
    //         'brands.slug',
    //         'brands.address',
    //         'brands.category_id',
    //         'brands.province_id',
    //         'brands.city_id',
    //         'brands.ipark_id',
    //         'brands.freezone_id',
    //         'brands.type',
    //     ]);

    //     // بررسی حالت های خاص X-Mode
    //     if(getMode() == 'freezone'){
    //         $query = $query->whereNotNull('freezone_id');
    //     }

    //     // لیست فیلترها و اعمال شرط به صورت داینامیک
    //     $filters = [
    //         'name' => fn($q, $value) => $q->where('name', 'like', "%{$value}%"),
    //         'province_id' => fn($q, $value) => $q->where('province_id', $value),
    //         'city_id' => fn($q, $value) => $q->where('city_id', $value),
    //         'ipark_id' => fn($q, $value) => $q->where('ipark_id', $value),
    //         'freezone' => fn($q, $value) => $q->where('freezone_id', $value),
    //     ];
    //     foreach ($filters as $key => $callback) {
    //         $value = request($key);
    //         if (filled($value) && $value != 0) {
    //             $callback($query, $value);
    //         }

    //     }

    //     // اجرای کوئری و فرمت خروجی
    //     $response = $query->paginate(30)->through(function ($brand) {
    //         return [
    //             'id' => $brand->id,
    //             'vip_expired_time' => $brand->vip_expired_time,
    //             'name' => $brand->name,
    //             // 'logo_path' => $brand->logo_path ? asset($brand->logo_path) : '',
    //             'logo_path' => $brand->logo_path,
    //             'slug' => $brand->slug,
    //             'address' => $brand->address,
    //             'category_id' => $brand->category_id,
    //             'category_name' => $brand->category?->name ?? '',
    //             'province_id' => $brand->province_id,
    //             'province_name' => $brand->province?->name ?? '',
    //             'city_id' => $brand->city_id,
    //             'city_name' => $brand->city?->name ?? '',
    //             'ipark_id' => $brand->ipark_id,
    //             'ipark_name' => $brand->ipark?->name ?? '',
    //             'freezone_id' => $brand->freezone_id,
    //             'freezone_name' => $brand->freezone?->name ?? '',
    //             'type_id' => $brand->type,
    //             'type_name' => $brand->brandType?->name ?? '',
    //         ];
    //     });

    //     $responseItems = $response->isEmpty() ? [] : $response->toArray()['data'];

    //     return ApplicationService::jsonFormat(['brands'=>$responseItems, 'is_final' => !$response->hasMorePages()]);
    //     // return ApplicationService::jsonFormat($response);
    // }
    public function brands()
    {
        // دریافت زبان فعلی
        $currentLocale = app()->getLocale();

        // تعریف کوئری با بارگذاری روابط و ترجمه‌ها
        $query = Brand::query()
            ->with([
                'province:id,name',
                'city:id,name',
                'ipark:id,name',
                'freezone:id,name',
                'category:id,name',
                'brandType:id,name',
                // افزودن روابط ترجمه
                'translation', // ترجمه برند
                'province.translation', // ترجمه استان
                'city.translation', // ترجمه شهر
                'ipark.translation', // ترجمه پارک صنعتی
                'freezone.translation', // ترجمه منطقه آزاد
                'category.translation', // ترجمه دسته‌بندی
                'brandType.translation' // ترجمه نوع برند
            ])
            ->latest()
            ->select([
                'brands.id',
                'brands.vip_expired_time',
                'brands.name',
                'brands.logo_path',
                'brands.slug',
                'brands.address',
                'brands.category_id',
                'brands.province_id',
                'brands.city_id',
                'brands.ipark_id',
                'brands.freezone_id',
                'brands.type',
            ]);

        // بررسی حالت های خاص X-Mode
        if(getMode() == 'freezone'){
            $query = $query->whereNotNull('freezone_id');
        }

        // لیست فیلترها و اعمال شرط به صورت داینامیک
        $filters = [
            'search' => fn($q, $value) => $q->where(function($qq) use ($value) {
                $qq->where('name', 'like', "%{$value}%")
                ->orWhereHas('translation', function($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                });
            }),
            'province_id' => fn($q, $value) => $q->where('province_id', $value),
            'city_id' => fn($q, $value) => $q->where('city_id', $value),
            'ipark_id' => fn($q, $value) => $q->where('ipark_id', $value),
            'freezone' => fn($q, $value) => $q->where('freezone_id', $value),
        ];

        foreach ($filters as $key => $callback) {
            $value = request($key);
            if (filled($value) && $value != 0) {
                $callback($query, $value);
            }
        }

        // اجرای کوئری و فرمت خروجی
        $response = $query->paginate(30)->through(function ($brand) use ($currentLocale) {
            return [
                'id' => $brand->id,
                'vip_expired_time' => $brand->vip_expired_time,
                'name' => $currentLocale === 'fa' ? $brand->name : ($brand->translation->name ?? $brand->name),
                'logo_path' => $brand->logo_path,
                'slug' => $brand->slug,
                'address' => $currentLocale === 'fa' ? $brand->address : ($brand->translation->address ?? $brand->address),
                'category_id' => $brand->category_id,
                'category_name' => $brand->category ? (
                    $currentLocale === 'fa'
                        ? $brand->category->name
                        : ($brand->category->translation->name ?? $brand->category->name)
                ) : '',
                'province_id' => $brand->province_id,
                'province_name' => $brand->province ? (
                    $currentLocale === 'fa'
                        ? $brand->province->name
                        : ($brand->province->translation->name ?? $brand->province->name)
                ) : '',
                'city_id' => $brand->city_id,
                'city_name' => $brand->city ? (
                    $currentLocale === 'fa'
                        ? $brand->city->name
                        : ($brand->city->translation->name ?? $brand->city->name)
                ) : '',
                'ipark_id' => $brand->ipark_id,
                'ipark_name' => $brand->ipark ? (
                    $currentLocale === 'fa'
                        ? $brand->ipark->name
                        : ($brand->ipark->translation->name ?? $brand->ipark->name)
                ) : '',
                'freezone_id' => $brand->freezone_id,
                'freezone_name' => $brand->freezone ? (
                    $currentLocale === 'fa'
                        ? $brand->freezone->name
                        : ($brand->freezone->translation->name ?? $brand->freezone->name)
                ) : '',
                'type_id' => $brand->type,
                'type_name' => $brand->brandType ? (
                    $currentLocale === 'fa'
                        ? $brand->brandType->name
                        : ($brand->brandType->translation->name ?? $brand->brandType->name)
                ) : '',
            ];
        });

        $responseItems = $response->isEmpty() ? [] : $response->toArray()['data'];
        return ApplicationService::jsonFormat(['brands'=>$responseItems, 'is_final' => !$response->hasMorePages()]);
    }

    // public function products()
    // {
    //     $query = Product::query()
    //         ->with(['brand:id,name,province_id,city_id,ipark_id,freezone_id',
    //                 'brand.province:id,name',
    //                 'brand.city:id,name',
    //                 'brand.ipark:id,name',
    //                 'brand.freezone:id,name'])
    //         ->latest()
    //         ->select(['id', 'name', 'brand_id', 'image', 'slug']); // فیلدهای مورد نیاز از product

    //     // فیلتر کردن بر اساس برند در حالت freezone
    //     if (getMode() === 'freezone') {
    //         $query->whereHas('brand', function ($q) {
    //             $q->whereNotNull('freezone_id');
    //         });
    //     }

    //     // فیلتر کردن نام محصول
    //     if ($name = request('name')) {
    //         $query->where('name', 'like', "%{$name}%");
    //     }

    //     // فیلترهای مربوط به برند
    //     $brandFilters = [
    //         'province' => 'province_id',
    //         'city' => 'city_id',
    //         'ipark' => 'ipark_id',
    //         'freezone' => 'freezone_id',
    //     ];

    //     foreach ($brandFilters as $requestKey => $column) {
    //         $value = request($requestKey);
    //         if (filled($value) && $value != 0) {
    //             $query->whereHas('brand', function ($q) use ($column, $value) {
    //                 $q->where($column, $value);
    //             });
    //         }
    //     }

    //     $response = $query->paginate(30)->through(function ($product) {
    //         return [
    //             'name' => $product->name,
    //             // 'image' => $product->image ? asset($product->image) : null,
    //             'image' => $product->image,
    //             'slug'=> $product->slug,
    //         ];
    //     });

    //     $responseItems = $response->isEmpty() ? [] : $response->toArray()['data'];

    //     // return ApplicationService::jsonFormat($response);
    //     return ApplicationService::jsonFormat(['products'=>$responseItems, 'is_final' => !$response->hasMorePages()]);
    // }
    public function products()
{
    // دریافت زبان فعلی
    $currentLocale = app()->getLocale();

    $query = Product::query()
        ->with([
            'brand:id,name,province_id,city_id,ipark_id,freezone_id',
            'brand.province:id,name',
            'brand.city:id,name',
            'brand.ipark:id,name',
            'brand.freezone:id,name',
            // افزودن روابط ترجمه
            'translation', // ترجمه محصول
            'brand.translation', // ترجمه برند
            'brand.province.translation', // ترجمه استان
            'brand.city.translation', // ترجمه شهر
            'brand.ipark.translation', // ترجمه پارک صنعتی
            'brand.freezone.translation' // ترجمه منطقه آزاد
        ])
        ->latest()
        ->select(['id', 'name', 'brand_id', 'image', 'slug']); // فیلدهای مورد نیاز از product

    // فیلتر کردن بر اساس برند در حالت freezone
    if (getMode() === 'freezone') {
        $query->whereHas('brand', function ($q) {
            $q->whereNotNull('freezone_id');
        });
    }

    // فیلتر کردن نام محصول
    if ($name = request('search')) {
        $query->where(function($q) use ($name) {
            $q->where('name', 'like', "%{$name}%")
              ->orWhereHas('translation', function($q) use ($name) {
                  $q->where('name', 'like', "%{$name}%");
              });
        });
    }

    // فیلترهای مربوط به برند
    $brandFilters = [
        'province' => 'province_id',
        'city' => 'city_id',
        'ipark' => 'ipark_id',
        'freezone' => 'freezone_id',
    ];

    foreach ($brandFilters as $requestKey => $column) {
        $value = request($requestKey);
        if (filled($value) && $value != 0) {
            $query->whereHas('brand', function ($q) use ($column, $value) {
                $q->where($column, $value);
            });
        }
    }

    $response = $query->paginate(30)->through(function ($product) use ($currentLocale) {
        return [
            'name' => $currentLocale === 'fa' ? $product->name : ($product->translation->name ?? $product->name),
            'image' => $product->image,
            'slug' => $product->slug,
        ];
    });

    $responseItems = $response->isEmpty() ? [] : $response->toArray()['data'];
    return ApplicationService::jsonFormat(['products'=>$responseItems, 'is_final' => !$response->hasMorePages()]);
}
}
