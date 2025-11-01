<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function home(){
        $categories = Category::where('parent_id' , null)->get();
        $products = Product::query();
        if(isset($_GET['brand'])){
            $products = Brand::find($_GET['brand'])->products->toQuery();
        }
        if(isset($_GET['search'])){
            $products = $products->where('name','LIKE','%'.$_GET['search'].'%');
        }
        $products_all = $products->get();
        $products = $products->get();
        $brands = [];
        foreach($products_all as $product){
            foreach($product->brands as $brand){
                $brands[$brand->id] = $brand->name;
            }
        }
        $iparks = Ipark::all();
        return view('user.search' , compact('products' , 'brands' , 'iparks'));
    }
    public function main(){
        // $products = Product::all();
        // foreach($products as $product){
        //     if(!$product->brand){
        //         $product->delete();
        //     }
        //     $product->category_id = $product->brand->category_id;
        //     $product->save();
        // }
        $newProducts = Product::orderBy('created_at' , 'desc')->limit(12)->get();
        $mostPopulars = Product::inRandomOrder()->limit(12)->get();
        $categories = Category::where('parent_id' , null)->orderBy('search_url')->get();
        $provinces = Province::all();
        $cities = City::all();
        $iparks = Ipark::all();
        return view('user.main' , compact(['newProducts' , 'mostPopulars' , 'categories' , 'provinces' , 'cities' , 'iparks']));
    }
}
