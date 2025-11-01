<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Product;
use App\Models\Province;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function products(): Response|ResponseFactory
    {
        //set Categories
        $productsPerPage = $_GET['per_page'] ?? 10;
        $category = $_GET['category'] ?? null;
        $categories = [
            'parent' => null,
            'current' => null,
        ];
        if ($category) {
            $category = Category::whereId($category)->select('id', 'name', 'code', 'parent_id')->first();
            $categories['current'] = $category;
            if (is_null(!$category->getAttribute('parent_id'))) {
                $categories['parent'] = Category::whereId($category->getAttribute('parent_id'))->get(['name', 'id', 'code']);
            }
            $categories['items'] = Category::where('parent_id', $category->getAttribute('id'))->get(['name', 'id', 'code']);
        } else {
            $categories['items'] = Category::where('parent_id', null)->get(['name', 'id', 'code']);
        }
        // get products
        $products = Product::query()->with(['attributes' => function ($query) {
            $query->select(['name', 'value', 'product_id']);
        }]);
        $products = $products->leftJoin('brands', 'brands.id', '=', 'products.brand_id');
        $products = $products->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        if (isset($_GET['search'])) {
            $products = $products->where('products.name', 'LIKE', '%' . $_GET['search'] . '%');
        }
        if (isset($_GET['province'])) {
            $products = $products->where('brands.province_id', $_GET['province']);
        }
        if (isset($_GET['city'])) {
            $products = $products->where('brands.city_id', $_GET['city']);
        }
        if (isset($_GET['ipark'])) {
            $products = $products->where('brands.ipark_id', $_GET['ipark']);
        }
        if (isset($_GET['is_exportable']) && $_GET['is_exportable'] == 'true') {
            $products = $products->where('products.isExportable', 1);
        }
        if ($category) {
            $code = rtrim($categories['current']->getAttribute('code'), "0");
            $filterCategories = Category::where('code', 'like', $code . '%')->pluck('id');
            $products = $products->whereIn('products.category_id', $filterCategories);
        }
        $products = $products->select([
            'products.id',
            'products.name',
            'products.slug',
            'products.image',
            'brands.name as brand_name',
            'categories.name as category_name',
            'products.isExportable'
        ]);
        $products = $products
            ->inRandomOrder()
            ->paginate($productsPerPage)
            ->withQueryString()
            ->through(function ($products) {
                $products->setAttribute('image', asset($products->getAttribute('image')));
                return $products;
            });
        $provinces = Province::select(['name', 'id'])->get();
        $cities = null;
        $iparks = null;
        if (isset($_GET['province'])) {
            $cities = City::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $iparks = Ipark::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
        }
        $data = [
            'filters' => [
                'categories' => $categories,
                'is_exportable' => isset($_GET['is_exportable']) && $_GET['is_exportable'] == 'true',
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'selectedFilters' => [
                    'category' => $category ? ['label' => 'دسته بندی', 'param' => 'category', 'value' => $category->getAttribute('name')] : null,
                    'province' => isset($_GET['province']) ? ['label' => 'استان', 'param' => 'province', 'value' => Province::whereId($_GET['province'])->first()->getAttribute('name')] : null,
                    'city' => isset($_GET['city']) ? ['label' => 'شهر', 'param' => 'city', 'value' => City::whereId($_GET['city'])->first()->getAttribute('name')] : null,
                    'ipark' => isset($_GET['ipark']) ? ['label' => 'شهرک صنعتی', 'param' => 'ipark', 'value' => Ipark::whereId($_GET['ipark'])->first()->getAttribute('name')] : null,
                    'search' => isset($_GET['search']) ? ['label' => 'جستجو', 'param' => 'search', 'value' => $_GET['search']] : null,
                    'is_exportable' => isset($_GET['is_exportable']) ? ['label' => 'فیلتر', 'param' => 'is_exportable', 'value' => 'محصولات صادراتی'] : null
                ]
            ],
            'products' => $products,
            'resultFor' => $_GET['search'] ?? (isset($_GET['category']) ? $category->name : null)
        ];
        return inertia('Products', [
            'data' => $data
        ]);
    }

    public function explore(): \Illuminate\Http\JsonResponse
    {
        $products = Product::inRandomOrder()
            ->limit(50)
            ->get(['id', 'name', 'slug', 'image'])
            ->map(function ($product) {
                $imageUrl = $product->getAttribute('image') ? asset($product->getAttribute('image')) : 'https://fakeimg.pl/180x180/?text=No%20Image';
                $product->setAttribute('image', $imageUrl);
                return $product;
            });
        return response()->json(['products' => $products->toArray()]);
    }

    public function brands(): Response|ResponseFactory
    {
        $brandsPerPage = $_GET['per_page'] ?? 10;
        $categories = Category::where('parent_id', null)->get(['name', 'id', 'code']);
        $category = $_GET['category'] ?? null;
        if ($category) {
            $category = Category::whereId($category)->select('id', 'name', 'code', 'parent_id')->first();
        }
        $brands = Brand::query();
        $brands = $brands->leftJoin('categories', 'categories.id', '=', 'brands.category_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'brands.province_id')
            ->leftJoin('cities', 'cities.id', '=', 'brands.city_id');
        if (isset($_GET['search'])) {
            $brands = $brands->where('brands.name', 'LIKE', '%' . $_GET['search'] . '%');
        }
        if (isset($_GET['province'])) {
            $brands = $brands->where('brands.province_id', $_GET['province']);
        }
        if (isset($_GET['city'])) {
            $brands = $brands->where('brands.city_id', $_GET['city']);
        }
        if (isset($_GET['ipark'])) {
            $brands = $brands->where('brands.ipark_id', $_GET['ipark']);
        }
        $brands = $brands->select([
            'brands.id',
            'brands.name',
            'brands.slug',
            // 'brands.logo_path',
            DB::raw("CONCAT('" . asset('') . "', brands.logo_path) as logo_path"),
            'provinces.name as province_name',
            'cities.name as city_name',
            'categories.name as category_name',
        ]);
        $brands = $brands->with(['products' => function ($q) {
            $q->select(['id', 'brand_id', 'name', 'slug', DB::raw("CONCAT('" . asset('') . "', image) as image")])->limit(3);
        }]);
        $brands = $brands->inRandomOrder()->paginate($brandsPerPage)->withQueryString();

        $provinces = Province::select(['name', 'id'])->get();
        $cities = null;
        $iparks = null;
        if (isset($_GET['province'])) {
            $cities = City::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $iparks = Ipark::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
        }
        $data = [
            'filters' => [
                'categories' => ['items' => $categories],
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'selectedFilters' => [
                    'category' => $category ? ['label' => 'دسته بندی', 'param' => 'category', 'value' => $category->getAttribute('name')] : null,
                    'province' => isset($_GET['province']) ? ['label' => 'استان', 'param' => 'province', 'value' => Province::whereId($_GET['province'])->first()->getAttribute('name')] : null,
                    'city' => isset($_GET['city']) ? ['label' => 'شهر', 'param' => 'city', 'value' => City::whereId($_GET['city'])->first()->getAttribute('name')] : null,
                    'ipark' => isset($_GET['ipark']) ? ['label' => 'شهرک صنعتی', 'param' => 'ipark', 'value' => Ipark::whereId($_GET['ipark'])->first()->getAttribute('name')] : null,
                    'search' => isset($_GET['search']) ? ['label' => 'جستجو', 'param' => 'search', 'value' => $_GET['search']] : null
                ]
            ],
            'brands' => $brands,
            'resultFor' => $_GET['search'] ?? (isset($_GET['category']) ? $category->name : null)
        ];
        return inertia('Brands', [
            'data' => $data
        ]);
    }
}
