<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisiong;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Province;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    public function index(){
        $provinces = Province::all();
        $cities = City::all();
        $iparks = Ipark::all();
        $categories = Category::where('parent_id' , null)->get();
        $blogs = Advertisiong::paginate(96);
        return view('user.advertising.all' , compact(['provinces' , 'cities' , 'iparks' , 'categories' , 'blogs']));
    }

    public function show(string $id){
        $news = Advertisiong::find($id);
        return view('user.advertising.show' , compact(['news']));
    }
}
