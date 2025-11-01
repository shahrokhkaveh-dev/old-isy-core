<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Province;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function all(){
        $brands = Brand::where('status' , 2)->whereNot('name','بی نام');
        if(isset($_GET['search'])){
            $brands = $brands->where('name' , 'LIKE' , '%'.$_GET['search'].'%');
        }
        if(isset($_GET['province_id']) && $_GET['province_id']){
            $brands = $brands->where('province_id' , $_GET['province_id']);
            $cities = City::where('province_id' , $_GET['province_id'])->get();
            if(isset($_GET['city_id']) && $_GET['city_id']){
                $brands = $brands->where('city_id' , $_GET['city_id']);
            }
        }else{
            $cities = City::all();
        }
        if(isset($_GET['category_id']) && $_GET['category_id']){
            $brands = $brands->where('category_id',$_GET['category_id']);
        }
        if(isset($_GET['type_id']) && $_GET['type_id']){
            $brands = $brands->where('type',$_GET['type_id']);
        }
        if(isset($_GET['ipark_id']) && $_GET['ipark_id']){
            $brands = $brands->where('ipark_id',$_GET['ipark_id']);
        }
        $brands = $brands->paginate(96);
        $provinces = Province::all();
        $categories = Category::where('parent_id' , null)->orderBy('search_url')->get();
        $types = Type::all();
        $iparks = Ipark::all();
        return view('web.companies' , compact('brands' , 'categories' , 'provinces' , 'cities' , 'types' ,'iparks'));
    }

    public function show($slug){
        $brand = Brand::where('slug' , $slug)->first();
        $images = DB::table('brand_images')->where('brand_id' , $brand->id)->get();
        return view('web.brand' , compact('brand' , 'images'));
    }
}
