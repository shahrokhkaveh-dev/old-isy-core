<?php

namespace App\Repositories\Category;

use App\Enumerations\Category\Fields;
use App\Enums\CommonFields;
use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Category());
    }

    public function getCategoryChildren($id = null)
    {
        return $this->model->where('parent_id', $id)->get(['id', 'name', 'slug', 'icons', 'code']);
    }

    public function getChildrenFromCode($code): ?array
    {
        $code = rtrim($code, '0');
        $categories = $this->model->where('code', 'like', "{$code}%")->get()->pluck('id');
        return $categories ? $categories->toArray() : null;
    }

    public function homeCategories(): array
    {
        $mainCategories = $this->model->whereNull('parent_id')
            ->with([
                'childs:id,name,code,parent_id',
                'childs.childs:id,name,code,parent_id',
            ])
            ->select(['id', 'name', 'code', 'parent_id'])
            ->limit(15)
            ->get();
        $moreCategories = $this->model->whereNull('parent_id')
            ->with([
                'childs:id,name,code,parent_id',
                'childs.childs:id,name,code,parent_id',
            ])
            ->select(['id', 'name', 'code', 'parent_id'])
            ->offset(15)
            ->limit(15)
            ->get();
        return ['main' => $mainCategories, 'more' => $moreCategories];
    }

    // public function fetchCategories($parentId = null): array
    // {
    //     $categories = $this->model->where(Fields::PARENT_ID->value, $parentId)
    //         ->select([CommonFields::ID, Fields::NAME->value])
    //         ->withCount('childs')
    //         ->get()
    //         ->map(fn($category) => [
    //             CommonFields::ID => $category->getAttribute(CommonFields::ID),
    //             Fields::NAME->value => $category->getAttribute(Fields::NAME->value),
    //             'has_children' => $category->childs_count > 0
    //         ]);
    //     return $categories ? $categories->toArray() : [];
    // }
    public function fetchCategories($parentId = null): array
    {
        // دریافت زبان فعلی
        $currentLocale = \request()->header('X-Lang') ?? 'fa';

        $categories = $this->model->where(Fields::PARENT_ID->value, $parentId)
            ->with([
                'translations' => function ($query) use ($currentLocale) {
                    $query->where('locale', $currentLocale);
                },
                'childs.translations' => function ($query) use ($currentLocale) {
                    $query->where('locale', $currentLocale);
                }
            ])
            ->withCount('childs')
            ->get()
            ->map(function ($category) use ($currentLocale) {
                return [
                    CommonFields::ID => $category->getAttribute(CommonFields::ID),
                    Fields::NAME->value => $currentLocale === 'fa'
                        ? $category->getAttribute(Fields::NAME->value)
                        : ($category->translations?->first()->name ?? $category->getAttribute(Fields::NAME->value)),
                    'has_children' => $category->childs_count > 0
                ];
            });

        return $categories ? $categories->toArray() : [];
    }

    public function getMainCategoryBrands($limit = 10)
    {
        $currentLocale = app()->getLocale();

        $brandsSubQuery = DB::table('brands')
            ->select([
                'brands.id',
                'brands.category_id',
                'brands.logo_path',
                'brands.slug',
                'cities.id as city_id',
                DB::raw("COALESCE(city_translates.name, cities.name) as city_name"),
                'provinces.id as province_id',
                DB::raw("COALESCE(province_translates.name, provinces.name) as province_name"),
                DB::raw("COALESCE(brand_translates.name, brands.name) as brand_name"),
                DB::raw('ROW_NUMBER() OVER (PARTITION BY brands.category_id ORDER BY brands.id DESC) as rn')
            ])
            ->whereNotNull('category_id')
            ->leftJoin('brand_translates', function ($join) use ($currentLocale) {
                $join->on('brand_translates.brand_id', '=', 'brands.id')
                    ->where('brand_translates.locale', $currentLocale);
            })
            ->leftJoin('cities', 'brands.city_id', '=', 'cities.id')
            ->leftJoin('city_translates', function ($join) use ($currentLocale) {
                $join->on('cities.id', '=', 'city_translates.city_id')
                    ->where('city_translates.locale', '=', $currentLocale);
            })
            ->leftJoin('provinces', 'cities.province_id', '=', 'provinces.id')
            ->leftJoin('province_translates', function ($join) use ($currentLocale) {
                $join->on('provinces.id', '=', 'province_translates.province_id')
                    ->where('province_translates.locale', '=', $currentLocale);
            });

        $flatResult = Category::whereNull('parent_id')
            ->select([
                'categories.id',
                DB::raw("COALESCE(category_translates.name, categories.name) as category_name"),
                'ranked_brands.id as brand_id',
                'ranked_brands.brand_name',
                'ranked_brands.logo_path as brand_logo_path',
                'ranked_brands.slug as brand_slug',
                'ranked_brands.city_id as brand_city_id',
                'ranked_brands.city_name as brand_city_name',
                'ranked_brands.province_id as brand_province_id',
                'ranked_brands.province_name as brand_province_name'
            ])
            ->leftJoin('category_translates', function ($join) use ($currentLocale) {
                $join->on('category_translates.category_id', '=', 'categories.id')
                    ->where('category_translates.locale', $currentLocale);
            })->leftJoinSub($brandsSubQuery, 'ranked_brands', function ($join) {
                $join->on('categories.id', '=', 'ranked_brands.category_id');
            })
            ->where(function (Builder $query) use ($limit) {
                $query->whereNull('ranked_brands.id')
                    ->orWhere('ranked_brands.rn','<=',  $limit);
            })->get();

        $structuredCategories = $flatResult->groupBy('id')->map(function ($categoryGroup) {
            $category = $categoryGroup->first();
            $category->name = $category->category_name;
            unset(
                $category->brand_id,
                $category->brand_name,
                $category->brand_slug,
                $category->brand_logo_path,
                $category->category_name,
                $category->brand_city_id,
                $category->brand_city_name,
                $category->brand_province_id,
                $category->brand_province_name
            );
            $brands = $categoryGroup->filter(function($item){
                return !is_null($item->brand_id);
            })->map(function ($item) use ($category){
                return (object) [
                    'id' => $item->brand_id,
                    'name' => $item->brand_name,
                    'logo_path' => $item->brand_logo_path,
                    'slug' => $item->brand_slug,
                    'category_name' => $category->name,
                    'city' => (object) [
                        'id' => $item->brand_city_id,
                        'name' => $item->brand_city_name
                    ],
                    'province' => (object) [
                        'id' => $item->brand_province_id,
                        'name' => $item->brand_province_name
                    ]
                ];
            })->values();
            $category->setRelation('brands', $brands);
            return $category;
        })->values();
        return $structuredCategories;
    }
}
