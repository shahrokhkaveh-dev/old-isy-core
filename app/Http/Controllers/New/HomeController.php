<?php

namespace App\Http\Controllers\New;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\ProductController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\VisitRepository;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    protected CategoryRepository $categoryRepository;
    protected ProductRepository $productRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->productRepository = new ProductRepository();
    }
    public function homePage(): \Illuminate\Http\JsonResponse
    {
        $targetCategories = Category::where('code', 'like', '18%')
            ->orWhere('code', 'like', '14%')
            ->pluck('id')
            ->toArray();

        $sec2Products = $this->productRepository->getRandomItems(items: 12, select: ['id', 'name', 'slug', 'image'], targetCategories: $targetCategories);
        //Section 3 Data
        $sec3Categories = $this->categoryRepository->newQuery()
            ->where('level', 1)
            ->inRandomOrder()
            ->whereIn('id', [326, 6321, 3414])
            ->get();
        $sec3Products = [];
        $selectedCategories = 0;
        foreach ($sec3Categories as $category) {
            if ($selectedCategories >= 3) {
                break;
            }
            $categories = array_merge(
                [$category->getAttribute('id')],
                $this->categoryRepository->getChildrenFromCode($category->getAttribute('code'))
            );
            $products = Product::whereIn('category_id', $categories)
                ->inRandomOrder()
                ->limit(8)
                ->get(['id', 'name', 'slug', 'image'])
                ->map(function ($product) {
                    $product->image = asset($product->image);
                    return $product;
                });
            if ($products->count() >= 8) {
                //$sec3Products[$category->getAttribute('name')] = [
                $sec3Products[$category->toArray()['name']] = [
                    'id' => $category->getAttribute('id'),
                    'code' => $category->getAttribute('code'),
                    'image' => asset($category->getAttribute('image')),
                    'images' => $category->getAttribute('image'),
                    'products' => $products,
                ];
                $selectedCategories++;
            }
        }
        //Section 4 Data
        $blogs = News::orderBy('created_at', 'desc')->limit(4)->get(['id', 'title', 'box_image_path'])->map(function ($blog) {
            $blog->box_image_path = asset($blog->box_image_path);
            return $blog;
        });
        //Section 5 Data
        $categories = $this->categoryRepository->newQuery()->whereIn('level', [3, 4])->inRandomOrder()->limit(24)->get(['name', 'code', 'id']);
        $banners = [];
        if (getMode() == 'freezone') {
            $banners = [
                asset('banner/baner1.webp'),
                asset('banner/baner2.webp'),
                asset('banner/baner3.webp'),
                asset('banner/baner4.webp'),
            ];
            $brannerObjects = [
                [
                    'image_url' => asset('banner/baner1.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner2.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner3.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner4.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
            ];
        } else {
            $banners = [
                asset("banner/1984080317.png"),
                asset("banner/1984080319.png"),
                asset("banner/1984080321.png"),
                asset("banner/1984080323.png"),
                // asset("banner/b1.jpg"),
                // asset("banner/b2.jpg"),
                // asset("banner/b3.jpg"),
            ];
            $brannerObjects = [
                [
                    'image_url' => asset('banner/Frame1984080326shahanmes.png'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/1984080323.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'ره-روشن-آفتاب-پارس'
                ],
                [
                    'image_url' => asset('banner/1984080321.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'شرکت-مجتمع-تولید-لوله-و-اتصالات-پلیمر-یاس'
                ],
                [
                    'image_url' => asset('banner/1984080319.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'آریا-پک-مهر'
                ],
                [
                    'image_url' => asset('banner/1984080317.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'مواد-مهندسی-رنگین-رزین-اسپید'
                ],
            ];
        }
        $data = [
            'section1' => [
                'categories' => $this->categoryRepository->homeCategories(),
                'banners' => $banners,
                'bannerObjects' => $brannerObjects,
                'products' => $this->productRepository->getRandomItems(items: 5, select: ['id', 'name', 'image', 'slug']),
            ],
            'section2' => [
                'products' => $sec2Products,
            ],
            'section3' => [
                'products' => $sec3Products,
            ],
            'section4' => [
                'blogs' => $blogs,
            ],
            'section5' => [
                'categories' => $categories,
            ],
        ];
        return ApplicationService::responseFormat(['data' => $data]);
    }

    public function homePage2()
    {
        $heroStats = Cache::remember('hero_stats', 3600, static function () {
            return [
                'todayVisitors' => 524,
//                'todayVisitors' => (new VisitRepository())->visitsTodayCount(),
                'countBrands' => Brand::count(),
                'countProducts' => Product::count(),
            ];
        });

        $heroCategories = $this->categoryRepository->homeCategories();

        $latestBrands = Brand::latest()
            ->with(['translation','category:id,name','province:id,name','city:name'])
            ->select(['id','name', 'category_id', 'province_id', 'city_id', 'slug', 'logo_path']);
        if(getMode() === 'freezone'){
            $latestBrands = $latestBrands->whereNotNull('freezone_id');
        }
        $latestBrands = $latestBrands->limit(10)->get();
        foreach ($latestBrands as $key => $brand){
            unset(
                $latestBrands[$key]['address'],
                $latestBrands[$key]['description'],
                $latestBrands[$key]['managment_name'],
                $latestBrands[$key]['managment_position'],
                $latestBrands[$key]['plan_name']);
        }

        $mainCategories = $this->categoryRepository->getMainCategoryBrands(10);
//        return $brands;
        $grouped = collect([
            0 => [8117],
            1 => [6321, 5717, 7505, 8116],
            2 => [1111, 2779, 4419, 4840],
            3 => [3689, 3414, 6842, 8115],
            4 => [6626, 2560, 4291, 5005, 6512, 7275],
            5 => [2926, 326, 564, 858, 2365, 4007, 7020],
        ]);
        $mainCategories = $grouped->map(static function ($ids) use ($mainCategories) {
           return $mainCategories->whereIn('id', $ids)->values();
        });

        if (getMode() == 'freezone') {
            $banners = [
                asset('banner/baner1.webp'),
                asset('banner/baner2.webp'),
                asset('banner/baner3.webp'),
                asset('banner/baner4.webp'),
            ];
            $brannerObjects = [
                [
                    'image_url' => asset('banner/baner1.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner2.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner3.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/baner4.webp'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
            ];
        } else {
            $banners = [
                asset("banner/1984080317.png"),
                asset("banner/1984080319.png"),
                asset("banner/1984080321.png"),
                asset("banner/1984080323.png"),
                // asset("banner/b1.jpg"),
                // asset("banner/b2.jpg"),
                // asset("banner/b3.jpg"),
            ];
            $brannerObjects = [
                [
                    'image_url' => asset('banner/Frame1984080326shahanmes.png'),
                    'tap_url' => '#',
                    'type' => 'general',
                    'slug' => '#'
                ],
                [
                    'image_url' => asset('banner/1984080323.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'ره-روشن-آفتاب-پارس'
                ],
                [
                    'image_url' => asset('banner/1984080321.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'شرکت-مجتمع-تولید-لوله-و-اتصالات-پلیمر-یاس'
                ],
                [
                    'image_url' => asset('banner/1984080319.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'آریا-پک-مهر'
                ],
                [
                    'image_url' => asset('banner/1984080317.png'),
                    'tap_url' => 'https://sanatyariran.com',
                    'type' => 'brandAds',
                    'slug' => 'مواد-مهندسی-رنگین-رزین-اسپید'
                ],
            ];
        }

        return ApplicationService::responseFormat(['data' => [
            'heroStats' => $heroStats,
            'heroCategories' => $heroCategories,
            'latestBrands' => $latestBrands,
            'brands' => $mainCategories,
            'ads' => [
                'banners' => $banners,
                'bannerObjects' => $brannerObjects,
            ]
        ]]);
    }

    public function getCategoryBrands()
    {

    }

    public function getCategories(): \Illuminate\Http\JsonResponse
    {
        return ApplicationService::responseFormat(['categories' => $this->categoryRepository->homeCategories()]);
    }
}
