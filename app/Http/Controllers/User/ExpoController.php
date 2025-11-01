<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;

class ExpoController extends Controller
{
    public function search()
    {
        $categories = Category::where('parent_id', null)->orderBy('search_url')->get();
        $products = Product::join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(['products.name', 'products.image', 'products.slug', 'products.category_id', 'products.brand_id', 'products.isExportable', 'brands.ipark_id', 'brands.province_id', 'brands.city_id']);
        if (isset($_GET['province_id']) && $_GET['province_id']) {
            $products = $products->where('brands.province_id', $_GET['province_id']);
            $cities = City::where('province_id', $_GET['province_id'])->get();
        } else {
            $cities = City::all();
        }
        if (isset($_GET['city_id']) && $_GET['city_id']) {
            $products = $products->where('brands.city_id', $_GET['city_id']);
        }
        if (isset($_GET['category_id']) && $_GET['category_id']) {
            $products = $products->where('products.category_id', $_GET['category_id']);
        }
        if (isset($_GET['ipark_id']) && $_GET['ipark_id']) {
            $products = $products->where('ipark_id', $_GET['ipark_id']);
        }
        $provinces = Province::all();
        $iparks = Ipark::all();
        $products = $products->inRandomOrder()->paginate(96);
        return view('user.expo', compact('products', 'categories', 'provinces', 'cities' , 'iparks'));
    }
}
