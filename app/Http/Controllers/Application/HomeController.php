<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\LetterBrand;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductInquery;
use App\Models\Wishlist;
use App\Services\Application\ApplicationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class HomeController extends Controller
{
    public function index()
    {
        $slider = [];
        if (getMode() == "freezone") {
            $slider = [
                [
                    'image_url' => 'freezonebanners/aras.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => 'freezonebanners/arvand.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => 'freezonebanners/chabahar.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => 'freezonebanners/kish.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => 'freezonebanners/qeshm.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
            ];
        } else {
            $slider = [
                [
                    'image_url' => 'banner/Frame1984080327shahanmesapp.png',
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => ''
                ],
                [
                    'image_url' => 'banner/1984080324app.png',
                    'tap_url' => '#',
                    'type' => 'brandAds',
                    'slug' => 'ره-روشن-آفتاب-پارس'
                ],
                [
                    'image_url' => 'banner/1984080322app.png',
                    'tap_url' => '#',
                    'type' => 'brandAds',
                    'slug' => 'شرکت-مجتمع-تولید-لوله-و-اتصالات-پلیمر-یاس'
                ],
                [
                    'image_url' => 'banner/1984080320app.png',
                    'tap_url' => '#',
                    'type' => 'brandAds',
                    'slug' => 'آریا-پک-مهر'
                ],
                [
                    'image_url' => 'banner/1984080318app.png',
                    'tap_url' => '#',
                    'type' => 'brandAds',
                    'slug' => 'مواد-مهندسی-رنگین-رزین-اسپید'
                ],
            ];
        }

        $banners = [];
        if (getMode() == 'global') {
            $banners = DB::table('products')->select('image')->inRandomOrder()->limit(2)->get()->toArray();
            $banners = [
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
            ];
        }

        $targetCategories = Category::where('code','like','18%')
            ->orWhere('code','like','14%')
            ->pluck('id')
            ->toArray();

        $popular_products = [];
        if (getMode() == 'global') {
            $popular_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with(['category:id,name', 'brand:id,name'])
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $popular_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        }
        $popular_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'],
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'] ?? '',
                'office_name' => $product['brand']['name'] ?? '',
            );
        }, $popular_products->toArray());


        $favorite_products = [];
        if (getMode() == 'global') {
            $favorite_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with(['category:id,name', 'brand:id,name'])
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $favorite_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        }

        $favorite_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'],
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'] ?? '',
                'office_name' => $product['brand']['name'] ?? '',
            );
        }, $favorite_products->toArray());

        $new_products = [];
        if (getMode() == 'global') {
            $new_products = Product::where('products.status', 1)
                ->latest()
                ->with(['category:id,name', 'brand:id,name'])
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $new_products = Product::where('products.status', 1)
                ->latest()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->whereIn('category_id', $targetCategories)
                ->limit(5)
                ->get();
        }
        $new_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'] ? asset($product['image']) : null,
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'],
                'office_name' => $product['brand']['name'],
            );
        }, $new_products->toArray());

        $new_brands = [];
        if (getMode() == 'global') {
            $new_brands = Brand::latest()
                ->limit(10)
                ->with(['province:id,name', 'city:id,name', 'ipark:id,name', 'category:id,name'])
                ->select([
                    'brands.id',
                    'brands.province_id',
                    'brands.city_id',
                    'brands.ipark_id',
                    'brands.name',
                    'brands.logo_path',
                    'brands.slug',
                    'brands.category_id',
                ])
                ->get()
                ->map(function ($brand) {
                    $brand->logo_path = $brand->logo_path ? asset($brand->logo_path) : null;
                    return $brand;
                });
        } elseif (getMode() == 'freezone') {
            $new_brands = Brand::latest()
                ->limit(10)
                ->with(['province:id,name', 'city:id,name', 'freezone:id,name', 'category:id,name'])
                ->where('brands.freezone_id', '!=', null)
                ->select([
                    'brands.id',
                    'brands.province_id',
                    'brands.city_id',
                    'brands.ipark_id',
                    'brands.name',
                    'brands.logo_path',
                    'brands.slug',
                    'brands.category_id',
                ])
                ->get()
                ->map(function ($brand) {
                    $brand->logo_path = $brand->logo_path ? asset($brand->logo_path) : null;
                    return $brand;
                });
        }

        $categories = Category::where('parent_id', null)->select(['id', 'name', 'image'])->get()->toArray();

        $unreadLettersCount = 0;
        $unreadInquiriesCount = 0;

        $tokenString = \request()->bearerToken(); // The actual token string you have
        if ($tokenString) {
            $token = PersonalAccessToken::findToken($tokenString);
            if ($token) {
                $user = $token->tokenable;
                $brand_id = $user->brand_id;
                if ($user->access(3)) {
                    try {
                        $unreadLettersCount = LetterBrand::where(['brand_id' => $brand_id, 'seen' => 0])->count();
                    } catch (\Throwable $th) {
                        $unreadLettersCount = 0;
                    }
                }

                if ($user->access(5)) {
                    try {
                        $unreadInquiriesCount = ProductInquery::where(['destination_id' => $brand_id, 'status' => 1])->count();
                    } catch (\Throwable $th) {
                        $unreadInquiriesCount = 0;
                    }
                }
            }
        }


        $data = [
            'slider' => $slider,
            'categories' => $categories,
            'popular_products' => $popular_products,
            'favorite_products' => $favorite_products,
            'banners' => $banners,
            'unreadLettersCount' => $unreadLettersCount,
            'unreadInquiriesCount' => $unreadInquiriesCount,
            'new_products' => $new_products,
            'new_brands' => $new_brands,
        ];
        return ApplicationService::responseFormat($data);
    }

    public function search()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $searchText = isset($_GET['search']) ? "'{$_GET['search']}'" : 'null';
        $province = (isset($_GET['province']) && $_GET['province'] != 0) ? $_GET['province'] : 'null';
        $city = (isset($_GET['city']) && $_GET['city'] > -1) ? $_GET['city'] : 'null';
        $ipark = (isset($_GET['ipark']) && $_GET['ipark'] != 0) ? $_GET['ipark'] : 'null';
        $freezone = (isset($_GET['freezone']) && $_GET['freezone'] != 0) ? $_GET['freezone'] : 'null';
        $category = (isset($_GET['category']) && $_GET['category'] != 0) ? $_GET['category'] : 'null';

        $products = DB::select("CALL `application_search_procedure`({$page}, {$searchText}, {$province}, {$city}, {$ipark}, {$freezone}, {$category});");

        $data = [
            'products' => $products,
            'is_final' => count($products) < 20
        ];
        return ApplicationService::responseFormat($data);
    }

    public function search2()
    {
        //set Categories
        $productsPerPage = $_GET['per_page'] ?? 30;
        if (!($productsPerPage > 0) || !($productsPerPage <= 90)) {
            $productsPerPage = 30;
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
        $products = Product::query()
            ->with([
                'brand' => function ($query) {
                    $query->select('id', 'province_id', 'city_id', 'ipark_id', 'freezone_id');
                },
                'brand.province' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.city' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.ipark' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.freezone' => function ($query) {
                    $query->select('id', 'name');
                },
                'category' => function ($query) {
                    $query->select('id', 'name', 'code', 'parent_id');
                }
            ])
            ->select([
                'products.id',
                'products.name as name',
                'products.slug as slug',
                'products.image as image',
            ]);
        // if(app()->getLocale() != 'fa'){
        //     $products = $products->with(['translation' => function($query) {
        //         $query->select('product_id', 'locale', 'name');
        //     }])->whereHas('translation', function($query) {
        //         $query->where('locale', app()->getLocale());
        //     });
        // }

        if (isset($_GET['search']) && $_GET['search']) {
            if (app()->getLocale() === 'fa' || app()->getLocale() === 'fa-IR') {
                $products = $products->where('products.name', 'LIKE', '%' . $_GET['search'] . '%');
            } else {
                $searchTerm = $_GET['search'];
                $products = $products->whereTranslation('name', "%$searchTerm%", 'LIKE');
            }
        }
        if (isset($_GET['province']) && $_GET['province']) {
            $products = $products->whereHas('brand', function ($query) {
                $query->where('province_id', $_GET['province']);
            });

            if (isset($_GET['city']) && $_GET['city'] > -1) {
            $products = $products->whereHas('brand', function ($query) {
                $query->where('city_id', $_GET['city']);
            });
        }
        }

        if (isset($_GET['ipark']) && $_GET['ipark']) {
            $products = $products->whereHas('brand', function ($query) {
                $query->where('ipark_id', $_GET['ipark']);
            });
        }
        if (isset($_GET['freezone']) && $_GET['freezone']) {
            $products = $products->whereHas('brand', function ($query) {
                $query->where('freezone_id', $_GET['freezone']);
            });
        }
        if (isset($_GET['is_exportable']) && $_GET['is_exportable'] == 'true') {
            $products = $products->where('products.isExportable', 1);
        }
        if ($category) {
            $category->load('childs');
            $filterCategories = getAllCategoryIds($category);
            //$products = $products->whereIn('products.category_id', $filterCategories);
            $products = $products->whereHas('brand', fn ($q) => $q->whereIn('category_id', $filterCategories));
        }
        if (getMode() == 'freezone') {
            $products = $products->whereHas('brand', function ($query) {
                $query->whereNotNull('freezone_id');
            });
        }

        $products = $products
            ->inRandomOrder()
            ->paginate($productsPerPage)
            ->withQueryString();

        // Process products to handle translations
        $processedProducts = $products->getCollection()->map(function ($product) {
            // For non-Farsi locales, use translated name if available
            if (app()->getLocale() != 'fa' && $product->translation) {
                $product->name = $product->translation->name;
            }

            // Return only the required fields
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->image,
            ];
        });

        $products->setCollection($processedProducts);


        $data = [
            'products' => $products->items(),
            'is_final' => $products->currentPage() === $products->lastPage(),
            'total' => $products->total(),
        ];
        return ApplicationService::responseFormat($data);
    }

    public function product()
    {
        try {
            $slug = $_GET['slug'];
            $product = Product::with([
                'category' => function ($query) {
                    $query->select('id', 'name', 'image', 'parent_id');
                },
                'category.translation',
                'brand' => function ($query) {
                    $query->select('id', 'name', 'logo_path', 'province_id', 'city_id', 'ipark_id', 'slug', 'lat', 'lng');
                },
                'brand.translation',
                'brand.province' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.province.translation',
                'brand.city' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.city.translation',
                'brand.ipark' => function ($query) {
                    $query->select('id', 'name');
                },
                'brand.ipark.translation',
            ])
                ->where(['products.status' => 1, 'products.slug' => $slug, 'products.deleted_at' => null])
                ->first();

            if (!$product) {
                return ApplicationService::responseFormat([], false, 'product not found!', -1);
            }

            $user = auth('sanctum')->user();
            $wishlist = $user ? Wishlist::getList($user->id)->toArray() : [];
            $wishlist = array_column($wishlist, 'product_id');

            $attributes = ProductAttributes::where('product_id', $product->id)->get(['id', 'name', 'value']);

            // ساختار خروجی دقیقاً مشابه نسخه قبلی

            $result = [
                "id" => encrypt($product->id),
                "name" => $product->translation->name ?? $product->name,
                "image" => $product->image,
                "description" => $product->translation->description ?? $product->description,
                "excerpt" => $product->translation->excerpt ?? $product->excerpt,
                "isExportable" => $product->isExportable,
                "brand_id" => $product->brand ? encrypt($product->brand->id) : null,
                "HSCode" => $product->HSCode,
                "category_id" => $product->category ? $product->category->id : null,
                "category" => $product->category ? ($product->category->translation->name ?? $product->category->name) : null,
                "category_image" => $product->category ? $product->category->image : null,
                "brand" => $product->brand ? ($product->brand->translation->name ?? $product->brand->name) : null,
                "logo" => $product?->brand->logo_path ?? null,
                "province_id" => $product->brand ? $product->brand->province_id : null,
                "city_id" => $product?->brand->city_id ?? -1,
                "ipark_id" => $product->brand ? $product->brand->ipark_id : null,
                "brand_slug" => $product->brand ? $product->brand->slug : null,
                'brand_lat' => $product->brand ? $product->brand->lat : null,
                'brand_lng' => $product->brand ? $product->brand->lng : null,
                'province' => $product->brand && $product->brand->province ?
                    ($product->brand->province->translation->name ?? $product->brand->province->name) : null,
                'city' => $product->brand && $product->brand->city ?
                    ($product->brand->city->translation->name ?? $product->brand->city->name) : null,
                'ipark' => $product->brand && $product->brand->ipark ?
                    ($product->brand->ipark->translation->name ?? $product->brand->ipark->name) : null,
                'wishlist' => in_array($product->id, $wishlist),
                'attributes' => $attributes->toArray(),
            ];

            return ApplicationService::responseFormat($result);
        } catch (\Throwable $th) {
            // لاگ خطا برای دیباگ
            Log::error('Product detail error: ' . $th->getMessage(), [
                'slug' => $slug ?? null,
                'trace' => $th->getTraceAsString()
            ]);

            return ApplicationService::responseFormat([], false, 'An error occurred', -1);
        }
    }

    public function brand()
    {
        try {
            $slug = $_GET['slug'];

            $brand = Brand::with([
                'province' => function ($query) {
                    $query->select('id', 'name');
                },
                'province.translation',
                'city' => function ($query) {
                    $query->select('id', 'name');
                },
                'city.translation',
                'ipark' => function ($query) {
                    $query->select('id', 'name');
                },
                'ipark.translation',
                'category' => function ($query) {
                    $query->select('id', 'name');
                },
                'category.translation',
                'products' => function ($query) {
                    $query->select('id', 'brand_id', 'name', 'image', 'slug');
                },
                'products.translation',
                'brandImages' => function ($query) {
                    $query->select('brand_id', 'image_path', 'title');
                }
            ])
                ->where('slug', $slug)
                ->first();

            if (!$brand) {
                return ApplicationService::responseFormat([], false, 'Brand not found', -1);
            }

            $selectedIndexes = ['name', 'logo_path', 'nationality_code', 'register_code', 'phone_number', 'post_code', 'address', 'managment_name', 'managment_number', 'managment_profile_path', 'description', 'managment_position'];

            $data = [];
            foreach ($selectedIndexes as $value) {
                // Use translated value if available, otherwise use original
                $data['brand'][$value] = $brand->translation->{$value} ?? $brand->{$value};
            }

            // Handle related models with translations
            $data['brand']['province'] = $brand->province ? ($brand->province->translation->name ?? $brand->province->name) : null;
            $data['brand']['city'] = $brand->city ? ($brand->city->translation->name ?? $brand->city->name) : null;
            $data['brand']['ipark'] = $brand->ipark ? ($brand->ipark->translation->name ?? $brand->ipark->name) : null;
            $data['brand']['category'] = $brand->category ? ($brand->category->translation->name ?? $brand->category->name) : null;

            // Handle brand images
            $data['images'] = $brand->brandImages ? $brand->brandImages->toArray() : [];

            // Handle products with translations
            $products = $brand->products->map(function ($product) {
                return [
                    'id' => encrypt($product->id),
                    'name' => $product->translation->name ?? $product->name,
                    'image' => $product->image,
                    'slug' => $product->slug
                ];
            })->toArray();

            $data['products'] = $products;
            $data['brand']['product_count'] = count($products);
            $data['brand']['with_us'] = timeAgo($brand->created_at);
            $data['brand']['inquiry_count'] = ProductInquery::where('brand_id', $brand->id)->count();
            $data['brand']['lat'] = $brand->lat;
            $data['brand']['lng'] = $brand->lng;
            $data['brand']['id'] = encrypt($brand->id);

            return ApplicationService::responseFormat($data);
        } catch (\Throwable $th) {
            Log::error('Brand detail error: ' . $th->getMessage(), [
                'slug' => $slug ?? null,
                'trace' => $th->getTraceAsString()
            ]);

            return ApplicationService::responseFormat([], false, 'خطا در سرور', -2);
        }
    }

    public function brand_products(Request $request)
    {
        if($request->filled('slug')) {
            $brand = Brand::query()
                ->select(['id'])
                ->where('slug', $request->slug)
                ->first();
            if($brand) {
                $perPage = $request->get('per_page', 20);
                if($perPage < 1 && $perPage > 20)
                {
                    $perPage = 20;
                }
                $paginator = $brand
                    ->products()
                    ->select(['id', 'name', 'image', 'slug'])
                    ->with('translation:product_id,name')
                    ->when(
                        $request->filled('search'),
                        fn($q) => $q->where(
                            fn($q1) => $q1->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('translation', fn($q2) => $q2->where('name', 'like', '%' . $request->search . '%'))
                        )
                    )
                    ->paginate($perPage);
                if($paginator->total() > 0) {
                    $data = [
                        'products' => array_map(
                            fn($q) => [
                                'id' => encrypt($q->id),
                                'name' => $q->translation->name ?? $q->name,
                                'image' => $q->image,
                                'slug' => $q->slug,
                            ],
                            $paginator->items()
                        ),
                        'total' => $paginator->total(),
                        'current_page' => $paginator->currentPage(),
                        'last_page' => $paginator->lastPage(),
                        'per_page' => $paginator->perPage(),
                    ];
                    return ApplicationService::responseFormat($data);
                }
                return ApplicationService::responseFormat([], false, __('messages.brand_products_not_found'), -2);
            }
        }
        return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -1);
    }

    public function brands()
    {
        $page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : null;
        $searchText = $_GET['search'] ?? null;
        $province = (isset($_GET['province']) && $_GET['province'] != 0) ? $_GET['province'] : null;
        $city = (isset($_GET['city']) && $_GET['city'] > -1) ? $_GET['city'] : null;
        $ipark = (isset($_GET['ipark']) && $_GET['ipark'] != 0) ? $_GET['ipark'] : null;
        $freezone = (isset($_GET['freezone']) && $_GET['freezone'] != 0) ? $_GET['freezone'] : null;
        $category = (isset($_GET['category']) && $_GET['category'] != 0) ? $_GET['category'] : null;
        $type = (isset($_GET['type']) && $_GET['type'] != 0) ? $_GET['type'] : null;
        $brands = $this->getApplicationBrands($page, $searchText, $province, $city, $ipark, $freezone, $category, $type);
        $brands = array_map(function ($brand) {
            return collect($brand)->toArray();
        }, $brands);
        $data = [
            'brands' => $brands,
            'is_final' => count($brands) < 20
        ];
        return ApplicationService::responseFormat($data);
    }

    public function brands2(Request $request)
    {
        $page = $request->input('page', 0);
        $search = $request->input('search');
        $province = $request->input('province');
        $city = $request->input('city');
        $ipark = $request->input('ipark');
        $freezone = $request->input('freezone');
        $category = $request->input('category');
        $type = $request->input('type');
        $sortColumn = $request->input('sortColumn');
        $sortOrder = $request->input('sortOrder', 'asc');

        $query = Brand::query()->with([
            'category:id,name',
            'province:id,name',
            'city:id,name',
            'ipark:id,name',
            'freezone:id,name',
            'brandType:id,name'
        ])
            ->where('vip_expired_time', '>=', Carbon::now())
            ->where('category_id', '!=', null);

        $query->when(getMode() == 'freezone', fn($q) => $q->whereNotNull('freezone_id'))
            ->when($search, fn($q) => $q->where(
                fn($q1) => $q1->where('name', 'LIKE', "%{$search}%")
                ->orWhereHas('translation', fn($q2) => $q2->where('name', 'LIKE', "%{$search}%"))
            ))
            ->when($category, fn($q) => $q->where('category_id', $category))
            ->when($province, fn($q) => $q->where('province_id', $province))
            ->when($city !== null && $city > -1, fn($q) => $q->where('city_id', $city))
            ->when($ipark, fn($q) => $q->where('ipark_id', $ipark))
            ->when($freezone, fn($q) => $q->where('freezone_id', $freezone))
            ->when($type, fn($q) => $q->where('type', $type));

        if ($sortColumn) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $query->inRandomOrder();
        }

        $offset = $page * 30;
        $brandsCollection = $query->limit(30)->offset($offset)->get();

        $processedBrands = $brandsCollection->map(function ($brand) {
            return [
                'id' => $brand->id,
                'vip_expired_time' => $brand->vip_expired_time,
                'name' => $brand?->translation->name ?? $brand->name,
                'logo_path' => $brand->logo_path,
                'slug' => $brand->slug,
                'address' => $brand?->translation->address ?? $brand->address,
                'category_id' => $brand->category?->id,
                'category_name' => $brand->category?->translation->name ?? $brand->category?->name,
                'province_id' => $brand->province?->id,
                'province_name' => $brand->province?->translation->name ?? $brand->province?->name,
                'city_id' => $brand->city?->id,
                'city_name' => $brand->city?->translation->name ?? $brand->city?->name,
                'ipark_id' => $brand->ipark?->id,
                'ipark_name' => $brand->ipark?->translation->name ?? $brand->ipark?->name,
                'freezone_id' => $brand->freezone?->id,
                'freezone_name' => $brand->freezone?->translation->name ?? $brand->freezone?->name,
                'type_id' => $brand->brandType?->id,
                'type_name' => $brand->brandType?->translation->name ?? $brand->brandType?->name,
                'description' => $brand?->translation->description ?? $brand->description,
                'managment_name' => $brand?->translation->managment_name ?? $brand->managment_name,
                'managment_position' => $brand?->translation->managment_position ?? $brand->managment_position,
                'plan_name' => $brand->plan_name
            ];
        })->toArray();

        $data = [
            'brands' => $processedBrands,
            'is_final' => count($processedBrands) < 20,
            'total' => $query->count(),
        ];

        return ApplicationService::responseFormat($data);
    }

    public function version()
    {
        return ApplicationService::responseFormat(['latest_version' => (int) config('app.latest_version'), 'force_version' => (int) config('app.force_version')]);
    }

    function getApplicationBrands($page = 0, $search = null, $province = 0, $city = 0, $ipark = 0, $freezone = 0, $category = null, $type = 1): array
    {
        $brands = Brand::query()->with([
            'category' => function ($query) {
                $query->select('id', 'name');
            },
            'province' => function ($query) {
                $query->select('id', 'name');
            },
            'city' => function ($query) {
                $query->select('id', 'name');
            },
            'ipark' => function ($query) {
                $query->select('id', 'name');
            },
            'freezone' => function ($query) {
                $query->select('id', 'name');
            },
            'brandType' => function ($query) {
                $query->select('id', 'name');
            }
        ])
            ->where('brands.vip_expired_time', '>=', Carbon::now())
            ->where('brands.category_id', '!=', null);

        if (getMode() == 'freezone') {
            $brands = $brands->whereNotNull('brands.freezone_id');
        }

        if (!empty($search)) {
            $brands = $brands->where(function ($query) use ($search) {
                $query->where('brands.name', 'LIKE', "%{$search}%")
                    ->orWhereHas('translation', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // **فیلتر دسته‌بندی (category)**
        if (!empty($category)) {
            $brands = $brands->where('brands.category_id', $category);
        }

        // **فیلتر استان (province)**
        if (!empty($province)) {
            $brands = $brands->where('brands.province_id', $province);

            // **فیلتر شهر (city)**
            if (!is_null($city) && $city > -1) {
                $brands = $brands->where('brands.city_id', $city);
            }
        }

        // **فیلتر شهر (city)**
        //if (!is_null($city) && $city > -1) {
            //$brands = $brands->where('brands.city_id', $city);
        //}

        // **فیلتر ipark**
        if (!empty($ipark)) {
            $brands = $brands->where('brands.ipark_id', $ipark);
        }

        // **فیلتر منطقه آزاد (freezone)**
        if (!empty($freezone)) {
            $brands = $brands->where('brands.freezone_id', $freezone);
        }

        // **فیلتر نوع برند (type)**
        if (!empty($type)) {
            $brands = $brands->where('brands.type', $type);
        }

        // پارامترهای مرتب‌سازی
        $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null;
        $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc'; // ترتیب (پیش‌فرض: asc)

        if (!empty($sortColumn)) {
            $brands = $brands->orderBy('brands.' . $sortColumn, $sortOrder);
        } else {
            $brands = $brands->inRandomOrder();
        }

        // **صفحه‌بندی و ترتیب تصادفی**
        $offset = $page * 30;
        // dd($brands->inRandomOrder()->limit(30)->offset($offset)->get());
        $brands = $brands->limit(30)->offset($offset)->get();

        // Set Result
        $result = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'vip_expired_time' => $brand->vip_expired_time,
                'name' => $brand->translation->name ?? $brand->name,
                'logo_path' => $brand->logo_path,
                'slug' => $brand->slug,
                'address' => $brand->translation->address ?? $brand->address,
                'category_id' => $brand->category ? $brand->category->id : null,
                'category_name' => $brand->category ? ($brand->category->translation->name ?? $brand->category->name) : null,
                'province_id' => $brand->province ? $brand->province->id : null,
                'province_name' => $brand->province ? ($brand->province->translation->name ?? $brand->province->name) : null,
                'city_id' => $brand->city ? $brand->city->id : null,
                'city_name' => $brand->city ? ($brand->city->translation->name ?? $brand->city->name) : null,
                'ipark_id' => $brand->ipark ? $brand->ipark->id : null,
                'ipark_name' => $brand->ipark ? ($brand->ipark->translation->name ?? $brand->ipark->name) : null,
                'freezone_id' => $brand->freezone ? $brand->freezone->id : null,
                'freezone_name' => $brand->freezone ? ($brand->freezone->translation->name ?? $brand->freezone->name) : null,
                'type_id' => $brand->brandType ? $brand->brandType->id : null,
                'type_name' => $brand->brandType ? ($brand->brandType->translation->name ?? $brand->brandType->name) : null,
                'description' => $brand->translation->description ?? $brand->description,
                'managment_name' => $brand->translation->managment_name ?? $brand->managment_name,
                'managment_position' => $brand->translation->managment_position ?? $brand->managment_position,
                'plan_name' => $brand->plan_name
            ];
        });

        return $result ? $result->toArray() : [];
    }

    public function index2()
    {
        $slider = [];
        if (getMode() == "freezone") {
            $slider = [
                [
                    'image_url' => 'banner/notext1.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'banner/notext2.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'banner/notext3.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'banner/notext4.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'banner/notext5.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'banner/notext6.png',
                    'tap_url' => 'https://sanatyariran.com'
                ],
            ];
        } else {
            $slider = [
                [
                    'image_url' => 'assets/banners/01.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/02.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/03.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/04.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/05.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
            ];
        }

        $banners = [];
        if (getMode() == 'global') {
            $banners = DB::table('products')->select('image')->inRandomOrder()->limit(2)->get()->toArray();
            $banners = [
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/06.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
                [
                    'image_url' => 'assets/banners/07.jpg',
                    'tap_url' => 'https://sanatyariran.com'
                ],
            ];
        }

        $popular_products = [];
        if (getMode() == 'global') {
            $popular_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with(['category:id,name', 'brand:id,name'])
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $popular_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->limit(5)
                ->get();
        }
        $popular_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'],
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'],
                'office_name' => $product['brand']['name'],
            );
        }, $popular_products->toArray());


        $favorite_products = [];
        if (getMode() == 'global') {
            $favorite_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with(['category:id,name', 'brand:id,name'])
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $favorite_products = Product::where('products.status', 1)
                ->inRandomOrder()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->limit(5)
                ->get();
        }

        $favorite_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'],
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'],
                'office_name' => $product['brand']['name'],
            );
        }, $favorite_products->toArray());

        $new_products = [];
        if (getMode() == 'global') {
            $new_products = Product::where('products.status', 1)
                ->latest()
                ->with(['category:id,name', 'brand:id,name'])
                ->limit(5)
                ->get();
        } elseif (getMode() == 'freezone') {
            $new_products = Product::where('products.status', 1)
                ->latest()
                ->with([
                    'category:id,name',
                    'brand:id,name,freezone_id'
                ])
                ->whereHas('brand', function ($q) {
                    $q->whereNotNull('freezone_id');
                })
                ->limit(5)
                ->get();
        }
        $new_products = array_map(function ($product) {
            return array(
                'slug' => $product['slug'],
                'img' => $product['image'] ? asset($product['image']) : null,
                'name' => $product['name'],
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                'category' => $product['category']['name'],
                'office_name' => $product['brand']['name'],
            );
        }, $new_products->toArray());

        $new_brands = [];
        if (getMode() == 'global') {
            $new_brands = Brand::latest()
                ->limit(10)
                ->with(['province:id,name', 'city:id,name', 'ipark:id,name', 'category:id,name'])
                ->select([
                    'brands.id',
                    'brands.province_id',
                    'brands.city_id',
                    'brands.ipark_id',
                    'brands.name',
                    'brands.logo_path',
                    'brands.slug',
                    'brands.category_id',
                ])
                ->get()
                ->map(function ($brand) {
                    $brand->logo_path = $brand->logo_path ? asset($brand->logo_path) : null;
                    return $brand;
                });
        } elseif (getMode() == 'freezone') {
            $new_brands = Brand::latest()
                ->limit(10)
                ->with(['province:id,name', 'city:id,name', 'freezone:id,name', 'category:id,name'])
                ->where('brands.freezone_id', '!=', null)
                ->select([
                    'brands.id',
                    'brands.province_id',
                    'brands.city_id',
                    'brands.ipark_id',
                    'brands.name',
                    'brands.logo_path',
                    'brands.slug',
                    'brands.category_id',
                ])
                ->get()
                ->map(function ($brand) {
                    $brand->logo_path = $brand->logo_path ? asset($brand->logo_path) : null;
                    return $brand;
                });
        }

        $categories = Category::where('parent_id', null)->select(['id', 'name', 'image'])->get()->toArray();

        $unreadLettersCount = 0;
        $unreadInquiriesCount = 0;

        $tokenString = \request()->bearerToken(); // The actual token string you have
        if ($tokenString) {
            $token = PersonalAccessToken::findToken($tokenString);
            if ($token) {
                $user = $token->tokenable;
                $brand_id = $user->brand_id;
                if ($user->access(3)) {
                    try {
                        $unreadLettersCount = LetterBrand::where(['brand_id' => $brand_id, 'seen' => 0])->count();
                    } catch (\Throwable $th) {
                        $unreadLettersCount = 0;
                    }
                }

                if ($user->access(5)) {
                    try {
                        $unreadInquiriesCount = ProductInquery::where(['destination_id' => $brand_id, 'status' => 1])->count();
                    } catch (\Throwable $th) {
                        $unreadInquiriesCount = 0;
                    }
                }
            }
        }


        $data = [
            'slider' => $slider,
            'categories' => $categories,
            'popular_products' => $popular_products,
            'favorite_products' => $favorite_products,
            'banners' => $banners,
            'unreadLettersCount' => $unreadLettersCount,
            'unreadInquiriesCount' => $unreadInquiriesCount,
            'new_products' => $new_products,
            'new_brands' => $new_brands,
        ];
        return ApplicationService::responseFormat($data);
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
