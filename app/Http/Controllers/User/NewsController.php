<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\News;
use App\Models\Province;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $provinces = Province::all();
        $cities = City::all();
        $iparks = Ipark::all();
        $categories = Category::where('parent_id' , null)->get();
        $news = News::orderBy('created_at' , 'desc')->paginate(96);
        return view('web.blogs', compact(['provinces' , 'cities' , 'iparks' , 'categories' , 'news']));
    }

    public function show(string $id){
        // dd($id);
        $news = News::find($id);
        $newNews = News::latest()->limit(5)->get(['id' , 'title' , 'box_image_path','updated_at']);
        return view('web.article' , compact(['news','newNews']));
    }
}
