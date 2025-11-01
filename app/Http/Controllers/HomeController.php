<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\News;
use App\Models\Product;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::where('parent_id' , null)->get(['id','name','image']);
        $BestSellerProducts = Product::select('id', 'name', 'image', 'slug' , 'isExportable' , 'brand_id' , 'city_id' , 'province_id')
            ->with([
                'brand:id,name,slug',  // انتخاب فقط فیلدهای مورد نیاز از برند
                'city:id,name',  // انتخاب فیلدهای مورد نیاز از شهر
                'province:id,name'  // انتخاب فیلدهای مورد نیاز از استان
            ])
            ->inRandomOrder()  // انتخاب تصادفی محصولات
            ->limit(12)  // محدود کردن به 12 محصول
            ->get();

        $bestBrands = Brand::whereNotNull('logo_path')->inRandomOrder()->limit(7)->get(['logo_path', 'slug']);

        // $ُsuggestCategories = Category::whereNull('parent_id')->inRandomOrder()->take(3)->get(['id' , 'name'])->toArray();
        $suggestCategoriesProducts = [];
        $suggestCategories = Category::whereNull('parent_id')->inRandomOrder()->take(3)->get(['id' , 'name'])->toArray();
        foreach($suggestCategories as $id => $cat){
            $subCats = getCategoriesWithSubcategories($cat['id']);
            $subCats = array_map(function($subCat){return $subCat['id'];} , $subCats);
            $subCats[] = $cat['id'];

            $suggestCategoriesProducts[$cat['id']] = Product::whereIn('category_id' , $subCats)->inRandomOrder()->limit(12)->get(['image','slug'])->chunk(4);
        }

        $newBrands  = Brand::whereNot('name' , 'بی نام')->where('vip_expired_time' , '>=',Carbon::now())->with(['province', 'city', 'category'])
        ->orderBy('created_at', 'desc') // مرتب‌سازی بر اساس تاریخ ایجاد
        ->limit(6) // محدود به 6 شرکت
        ->get(['name', 'slug', 'logo_path', 'province_id', 'city_id', 'category_id']);


        $newNews = News::latest()->limit(4)->get(['id' , 'title' , 'box_image_path' , 'content'])->toArray();
        foreach ($newNews as $key => $post) {
            // حذف تگ‌های HTML و خلاصه کردن به 50 کاراکتر
            $post['summary'] = Str::limit(strip_tags($post['content']), 50);
            $newNews[$key] = $post;
        }
        // dd($newNews);
        return view('web.home' , compact(['categories', 'BestSellerProducts', 'bestBrands' , 'suggestCategoriesProducts' , 'suggestCategories' , 'newBrands', 'newNews']));
    }

}
