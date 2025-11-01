<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\ProductController;
use App\Models\News;
use App\Models\Product;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
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
    public function homePage(): \Inertia\Response
    {
        //Section 2 Data
//        $section2Categories = $this->categoryRepository->newQuery()->where('level',3)->inRandomOrder()->limit(12)->get();
//        $products = collect();
//        foreach ($section2Categories as $category) {
//            $categories = array_merge([$category->getAttribute('id')], $this->categoryRepository->getChildrenFromCode($category->getAttribute('code')));
//            $product = Product::whereIn('category_id', $categories)->inRandomOrder()->first();
//            $products->push([
//                'name'=>$category->getAttribute('name'),
//                'code'=>$category->getAttribute('code'),
//                'image'=> ($product && $product->getAttribute('image'))? asset($product->getAttribute('image')) : 'https://fakeimg.pl/197x120',
//            ]);
//        }
        $sec2Products = $this->productRepository->getRandomItems(items: 12, select: ['id', 'name', 'slug', 'image']);
        //Section 3 Data
        $sec3Categories = $this->categoryRepository->newQuery()
            ->where('level',1)
            ->inRandomOrder()
            ->whereIn('id',[326,6321,3414])
            ->get();
        $sec3Products = [];
        $selectedCategories = 0;
        foreach ($sec3Categories as $category) {
            if($selectedCategories >= 3){
                break;
            }
            $categories = array_merge(
                [$category->getAttribute('id')],
                $this->categoryRepository->getChildrenFromCode($category->getAttribute('code'))
            );
            $products = Product::whereIn('category_id', $categories)
                ->inRandomOrder()
                ->limit(8)
                ->get(['id', 'name', 'slug', 'image']);
            if ($products->count() >= 8) {
                $sec3Products[$category->getAttribute('name')] = [
                    'id' => $category->getAttribute('id'),
                    'code' => $category->getAttribute('code'),
                    'image' => $category->getAttribute('image'),
                    'images' => $category->getAttribute('image'),
                    'products' => $products,
                ];
                $selectedCategories++;
            }
//            $categories = array_merge([$category->getAttribute('id')], $this->categoryRepository->getChildrenFromCode($category->getAttribute('code')));
//            $products = Product::whereIn('category_id', $categories)->inRandomOrder()->limit(8)->get(['id', 'name', 'slug', 'image']);
//            $sec3Products[$category->getAttribute('name')]['id'] = $category->getAttribute('id');
//            $sec3Products[$category->getAttribute('name')]['code'] = $category->getAttribute('code');
//            $sec3Products[$category->getAttribute('name')]['image'] = $category->getAttribute('image');
//            $sec3Products[$category->getAttribute('name')]['images'] = $category->getAttribute('image');
//            $sec3Products[$category->getAttribute('name')]['products'] = $products;
        }
        //Section 4 Data
        $blogs = News::orderBy('created_at', 'desc')->limit(4)->get(['id', 'title', 'box_image_path']);
        //Section 5 Data
        $categories = $this->categoryRepository->newQuery()->whereIn('level',[3,4])->inRandomOrder()->limit(24)->get(['name', 'code','id']);
        $data = [
            'section1' => [
                'categories' => $this->categoryRepository->homeCategories(),
                'banners' => [
                    asset("banner/g4.png"),
                    asset("banner/g5.png"),
                    asset("banner/g6.png"),
                    asset("banner/g7.png"),
                    asset("banner/g8.png"),
                    asset("banner/g9.png"),
                ],
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
        return Inertia::render('Home', [
            'data' => $data
        ]);
    }
}
