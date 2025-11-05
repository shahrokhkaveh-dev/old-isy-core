<?php

namespace App\Http\Controllers\New;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Freezone;
use App\Models\Ipark;
use App\Models\Product;
use App\Models\Province;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function products(): \Illuminate\Http\JsonResponse
    {
        //set Categories
        $productsPerPage = $_GET['per_page'] ?? 10;
        if(!($productsPerPage > 0) || !($productsPerPage <= 30)){
            $productsPerPage = 10;
        }
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
        if(getMode() == 'freezone'){
            $products = $products->whereNotNull('brands.freezone_id');
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
        if (isset($_GET['freezone'])) {
            $products = $products->where('brands.freezone_id', $_GET['freezone']);
        }
        if (isset($_GET['is_exportable']) && $_GET['is_exportable'] == 'true') {
            $products = $products->where('products.isExportable', 1);
        }
        if ($category) {
            $category->load('childs');
            $filterCategories = getAllCategoryIds($category);
            $products = $products->whereIn('brands.category_id', $filterCategories);
        }
        $products = $products->select([
            'products.id',
            'products.name',
            'products.slug',
            'products.image',
            'brands.id as brand_id',
            'brands.name as brand_name',
            'brands.slug as brand_slug',
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
        $freezone = null;
        if (isset($_GET['province'])) {
            $cities = City::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $iparks = Ipark::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $freezone = Freezone::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
        }
        $data = [
            'filters' => [
                'categories' => $categories,
                'is_exportable' => isset($_GET['is_exportable']) && $_GET['is_exportable'] == 'true',
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'freezone' => $freezone,
                'selectedFilters' => [
                    'category' => $category ? ['label' => 'دسته بندی', 'param' => 'category', 'value' => $category->getAttribute('name')] : null,
                    'province' => isset($_GET['province']) ? ['label' => 'استان', 'param' => 'province', 'value' => Province::whereId($_GET['province'])->first()->getAttribute('name')] : null,
                    'city' => isset($_GET['city']) ? ['label' => 'شهر', 'param' => 'city', 'value' => City::whereId($_GET['city'])->first()->getAttribute('name')] : null,
                    'ipark' => isset($_GET['ipark']) ? ['label' => 'شهرک صنعتی', 'param' => 'ipark', 'value' => Ipark::whereId($_GET['ipark'])->first()->getAttribute('name')] : null,
                    'freezone' => isset($_GET['freezone']) ? ['label' => 'منطقه آزاد', 'param' => 'freezone', 'value' => Freezone::whereId($_GET['freezone'])->first()->getAttribute('name')] : null,
                    'search' => isset($_GET['search']) ? ['label' => 'جستجو', 'param' => 'search', 'value' => $_GET['search']] : null,
                    'is_exportable' => isset($_GET['is_exportable']) ? ['label' => 'فیلتر', 'param' => 'is_exportable', 'value' => 'محصولات صادراتی'] : null
                ]
            ],
            'products' => $products,
            'resultFor' => $_GET['search'] ?? (isset($_GET['category']) ? $category->name : null)
        ];
        return ApplicationService::responseFormat([
            'data' => $data
        ]);
    }

    public function products2(Request $request): \Illuminate\Http\JsonResponse
    {
        $productsPerPage = $request->input('per_page', 10);
        $productsPerPage = (is_numeric($productsPerPage) && $productsPerPage > 0 && $productsPerPage <= 30) ? (int)$productsPerPage : 10;

        $categoryId = $request->input('category');
        $searchTerm = $request->input('search');
        $provinceId = $request->input('province');
        $cityId = $request->input('city');
        $iparkId = $request->input('ipark');
        $freezoneId = $request->input('freezone');
        $isExportable = $request->boolean('is_exportable');

        $categories = [
            'parent' => null,
            'current' => null,
            'items' => collect(),
        ];

        $categoryModel = null;

        if ($categoryId) {
            $categoryModel = Category::with(['translation', 'parent', 'childs:id,name,code,parent_id'])->select('id', 'name', 'code', 'parent_id')->find($categoryId);
            if ($categoryModel) {
                $categories['current'] = $categoryModel;
                $categories['parent'] = $categoryModel['parent'];
                $categories['items'] = $categoryModel['childs'];
            }
        } else {
            // Get root categories if no specific category is selected.
            $categories['items'] = Category::whereNull('parent_id')->with('translation')->select(['id', 'name', 'id', 'code'])->get();
        }

        $productQuery = Product::with([
            'attributes' => fn($q) => $q->select('id', 'name', 'value', 'product_id'),
            'brand' => fn($q) => $q->select('id', 'name', 'slug', 'province_id', 'city_id', 'ipark_id', 'freezone_id', 'category_id'),
            'brand.province' => fn($q) => $q->select('id', 'name'),
            'brand.city' => fn($q) => $q->select('id', 'name'),
            'brand.ipark' => fn($q) => $q->select('id', 'name'),
            'brand.freezone' => fn($q) => $q->select('id', 'name'),
            'category' => fn($q) => $q->select('id', 'name'),
        ]);

        if ($searchTerm) {
            $productQuery->where('products.name', 'LIKE', '%' . $searchTerm . '%');
        }

        if (getMode() == 'freezone') {
            $productQuery->whereHas('brand', fn($q) => $q->whereNotNull('freezone_id'));
        }

        if ($provinceId) {
            $productQuery->whereHas('brand', fn($q) => $q->where('province_id', $provinceId));
        }

        if ($cityId) {
            $productQuery->whereHas('brand', fn($q) => $q->where('city_id', $cityId));
        }

        if ($iparkId) {
            $productQuery->whereHas('brand', fn($q) => $q->where('ipark_id', $iparkId));
        }

        if ($freezoneId) {
            $productQuery->whereHas('brand', fn($q) => $q->where('freezone_id', $freezoneId));
        }

        if ($isExportable) {
            $productQuery->where('products.isExportable', 1);
        }

        if ($categoryModel) {
            // Assuming getAllCategoryIds gets all IDs of the category and its descendants.
            $filterCategories = getAllCategoryIds($categoryModel);
            $productQuery->whereHas('brand', fn($q) => $q->whereIn('category_id', $filterCategories));
        }

        $products = $productQuery->select([
            'id', 'name', 'slug', 'image', 'brand_id', 'category_id', 'isExportable'
        ])
            ->inRandomOrder()
            ->paginate($productsPerPage)
            ->withQueryString()
            ->through(fn($product) => $product->setAttribute('image', asset($product->image)))
            ->toArray();

        $products['data'] = array_map(
            fn($item) => [
                "id" => $item['id'],
                "name" => $item['name'],
                "slug" =>  $item['slug'],
                "image" => $item['image'],
                "brand_id" => isset($item['brand']) ? $item['brand']['id'] : null,
                "brand_name" => isset($item['brand']) ? $item['brand']['name'] : null,
                "brand_slug" => isset($item['brand']) ? $item['brand']['slug'] : null,
                "category_name" => isset($item['category']) && isset($item['category']['name']) ? $item['category']['name'] : null,
                "isExportable" => $item['isExportable'],
                "description" => $item['description'],
                "excerpt" => $item['excerpt'],
                "attributes" => $item['attributes'],
            ],
            $products['data']
        );

        $provinces = Province::select('name', 'id')->get();
        $cities = $provinceId ? City::where('province_id', $provinceId)->select('name', 'id')->get() : null;
        $iparks = $provinceId ? Ipark::where('province_id', $provinceId)->select('name', 'id')->get() : null;
        $freezones = $provinceId ? Freezone::where('province_id', $provinceId)->select('name', 'id')->get() : null;

        $selectedFilterModels = [
            'province' => $provinceId ? Province::find($provinceId) : null,
            'city' => $cityId ? City::find($cityId) : null,
            'ipark' => $iparkId ? Ipark::find($iparkId) : null,
            'freezone' => $freezoneId ? Freezone::find($freezoneId) : null,
        ];

        $selectedFilters = [
            'category' => $categoryModel ? ['label' => __('dictionary.category'), 'param' => 'category', 'value' => $categoryModel->toArray()['name']] : null,
            'province' => $selectedFilterModels['province'] ? ['label' => __('dictionary.province'), 'param' => 'province', 'value' => $selectedFilterModels['province']->toArray()['name']] : null,
            'city' => $selectedFilterModels['city'] ? ['label' => __('dictionary.city'), 'param' => 'city', 'value' => $selectedFilterModels['city']->toArray()['name']] : null,
            'ipark' => $selectedFilterModels['ipark'] ? ['label' => __('dictionary.ipark'), 'param' => 'ipark', 'value' => $selectedFilterModels['ipark']->toArray()['name']] : null,
            'freezone' => $selectedFilterModels['freezone'] ? ['label' => __('dictionary.freezone'), 'param' => 'freezone', 'value' => $selectedFilterModels['freezone']->toArray()['name']] : null,
            'search' => $searchTerm ? ['label' => __('dictionary.search'), 'param' => 'search', 'value' => $searchTerm] : null,
            'is_exportable' => $isExportable ? ['label' => __('dictionary.filter'), 'param' => 'is_exportable', 'value' => __('dictionary.exports')] : null
        ];

        $data = [
            'filters' => [
                'categories' => $categories,
                'is_exportable' => $isExportable,
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'freezone' => $freezones,
                'selectedFilters' => $selectedFilters
            ],
            'products' => $products,
            'resultFor' => $searchTerm ?? ($categoryModel?->toArray()['name'] ?? null)
        ];

        return ApplicationService::responseFormat(['data' => $data]);
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
        return ApplicationService::responseFormat(['products' => $products->toArray()]);
    }

    public function brands(): \Illuminate\Http\JsonResponse
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
        ->leftJoin('cities', 'cities.id', '=', 'brands.city_id')
        ->where('brands.name', '!=', 'بی نام');
        // dd($brands->get());
    // ->having('products_count', '>', 3);
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
        if (isset($_GET['freezone'])) {
            $brands = $brands->where('brands.freezone_id', $_GET['freezone']);
        }
        if(getMode() == 'freezone'){
            $brands = $brands->whereNotNull('brands.freezone_id');
        }
        if ($category) {
            $brands = $brands->where('brands.category_id', $category->id);
        }
        $brands = $brands->select([
            'brands.id',
            'brands.name',
            'brands.slug',
            'brands.created_at',
            // 'brands.logo_path',
            DB::raw("CONCAT('" . asset('') . "', brands.logo_path) as logo_path"),
            'provinces.name as province_name',
            'cities.name as city_name',
            'categories.name as category_name',
        ]);
        $brands = $brands->withCount('products');
        // $brands = $brands->having('products_count', '>=' , '3');
        $brands = $brands->with(['products' => function ($q) {
            $q->select(['id', 'brand_id', 'name', 'slug', DB::raw("CONCAT('" . asset('') . "', image) as image")]);
        }]);
        $brands = $brands->orderBy('created_at', 'desc')->paginate($brandsPerPage)->withQueryString();

        $brands->each(function ($brand) {
            $brand->setRelation('products', $brand->products->take(3));
        });
        $provinces = Province::select(['name', 'id'])->get();
        $cities = null;
        $iparks = null;
        $freezone = null;
        if (isset($_GET['province'])) {
            $cities = City::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $iparks = Ipark::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
            $freezone = Freezone::where('province_id', $_GET['province'])->select(['name', 'id'])->get();
        }
        $data = [
            'filters' => [
                'categories' => ['items' => $categories],
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'freezone' => $freezone,
                'selectedFilters' => [
                    'category' => $category ? ['label' => 'دسته بندی', 'param' => 'category', 'value' => $category->getAttribute('name')] : null,
                    'province' => isset($_GET['province']) ? ['label' => 'استان', 'param' => 'province', 'value' => Province::whereId($_GET['province'])->first()->getAttribute('name')] : null,
                    'city' => isset($_GET['city']) ? ['label' => 'شهر', 'param' => 'city', 'value' => City::whereId($_GET['city'])->first()->getAttribute('name')] : null,
                    'freezone' => isset($_GET['freezone']) ? ['label' => 'منطقه آزاد', 'param' => 'freezone', 'value' => Freezone::whereId($_GET['freezone'])->first()->getAttribute('name')] : null,
                    'ipark' => isset($_GET['ipark']) ? ['label' => 'شهرک صنعتی', 'param' => 'ipark', 'value' => Ipark::whereId($_GET['ipark'])->first()->getAttribute('name')] : null,
                    'search' => isset($_GET['search']) ? ['label' => 'جستجو', 'param' => 'search', 'value' => $_GET['search']] : null
                ]
            ],
            'brands' => $brands,
            'resultFor' => $_GET['search'] ?? (isset($_GET['category']) ? $category->name : null)
        ];
        return ApplicationService::responseFormat([
            'data' => $data
        ]);
    }

    public function brands2(Request $request)//: \Illuminate\Http\JsonResponse
    {
        $brandsPerPage = $request->input('per_page', 10);
        $categoryId = $request->input('category', null);
        $search = $request->input('search', null);
        $provinceId = $request->input('province', null);
        $cityId = $request->input('city', null);
        $iparkId = $request->input('ipark', null);
        $freezoneId = $request->input('freezone', null);

        $categories = Category::query()->whereNull('parent_id')->get(['name', 'id', 'code']);
        $provinces = Province::all(['name', 'id']);

        $selectedCategory = $categoryId ? Category::query()->find($categoryId) : null;
        $selectedProvince = $provinceId ? Province::query()->find($provinceId) : null;
        $selectedCity = !is_null($cityId) && $cityId > -1 ? City::query()->find($cityId) : null;
        $selectedIpark = $iparkId ? Ipark::query()->find($iparkId) : null;
        $selectedFreezone = $freezoneId ? Freezone::query()->find($freezoneId) : null;

        $brands = Brand::query()
            ->select([
                'id', 'name', 'slug', 'created_at', 'logo_path',
                'address', 'description', 'managment_name', 'managment_position', 'plan_name',
                'category_id', 'province_id', 'city_id'
            ])
            ->selectRaw("CONCAT('" . asset('') . "', logo_path) as logo_path")
            ->with([
                'category:id,name',
                'province:id,name',
                'city:id,name'
            ])
            ->withCount('products')
            /* ->with(['products' => function ($query) {
                $query->select(['id', 'brand_id', 'name', 'slug', 'description', 'excerpt', 'image'])
                    ->selectRaw("CONCAT('" . asset('') . "', image) as image");
            }]) */
            ->where('name', '!=', 'بی نام')
            ->when($search, fn($query) => $query->where(
                fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->orWhereHas('translation', fn($q1) => $q1->where('name', 'LIKE', "%{$search}%"))
            )
            ->when($provinceId, fn($query) => $query->where('province_id', $provinceId))
            ->when(!is_null($cityId) && $cityId > -1, fn($query) => $query->where('city_id', $cityId))
            ->when($iparkId, fn($query) => $query->where('ipark_id', $iparkId))
            ->when($freezoneId, fn($query) => $query->where('freezone_id', $freezoneId))
            ->when(getMode() == 'freezone', fn($query) => $query->whereNotNull('freezone_id'))
            ->when($selectedCategory, fn($query) => $query->where('category_id', $selectedCategory->id))
            ->orderBy('created_at', 'desc')
            ->paginate($brandsPerPage)
            ->withQueryString();

        $brands->getCollection()->transform(function ($brand) {
            $brand->load([
                'products' => function ($query) {
                    $query->select(['id', 'brand_id', 'name', 'slug', 'description', 'excerpt', 'image'])
                        ->selectRaw("CONCAT('" . asset('') . "', image) as image")
                        ->latest()
                        ->take(3);
                }
            ]);
            return $brand;
        });

        $cities = $provinceId ? City::query()->where('province_id', $provinceId)->get(['name', 'id']) : null;
        $iparks = $provinceId ? Ipark::query()->where('province_id', $provinceId)->get(['name', 'id']) : null;
        $freezones = $provinceId ? Freezone::query()->where('province_id', $provinceId)->get(['name', 'id']) : null;

        $data = [
            'filters' => [
                'categories' => ['items' => $categories],
                'provinces' => $provinces,
                'cities' => $cities,
                'iparks' => $iparks,
                'freezone' => $freezones,
                'selectedFilters' => [
                    'category' => $selectedCategory ? ['label' => __('dictionary.category'), 'param' => 'category', 'value' => $selectedCategory->toArray()['name']] : null,
                    'province' => $selectedProvince ? ['label' => __('dictionary.province'), 'param' => 'province', 'value' => $selectedProvince->toArray()['name']] : null,
                    'city' => $selectedCity ? ['label' => __('dictionary.city'), 'param' => 'city', 'value' => $selectedCity->toArray()['name']] : null,
                    'freezone' => $selectedFreezone ? ['label' => __('dictionary.freezone'), 'param' => 'freezone', 'value' => $selectedFreezone->toArray()['name']] : null,
                    'ipark' => $selectedIpark ? ['label' => __('dictionary.ipark'), 'param' => 'ipark', 'value' => $selectedIpark->toArray()['name']] : null,
                    'search' => $search ? ['label' => __('dictionary.filter'), 'param' => 'search', 'value' => $search] : null
                ]
            ],
            'brands' => $brands,
            'resultFor' => $search ?? ($selectedCategory?->toArray()['name'])
        ];

        return ApplicationService::responseFormat(['data' => $data]);
    }
}

function getAllCategoryIds(Category $category)
{
    $ids = [$category->id];

    foreach ($category->childs as $child) {
        $ids = array_merge($ids, getAllCategoryIds($child));
    }

    return $ids;
}
