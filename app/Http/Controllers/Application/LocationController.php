<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\BrandType;
use App\Models\Category;
use App\Models\City;
use App\Models\Freezone;
use App\Models\Ipark;
use App\Models\Province;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function getData(Request $request, string $table, ?string $filterColumn = null, string $filterId = 'filter_id'): array
    {
        // $lang = app()->getLocale();
        $query = null;
        if($table == 'provinces'){
            $query = Province::query();
        }elseif($table == 'cities'){
            $query = City::query();
        }elseif($table == 'freezones'){
            $query = Freezone::query();
        }elseif($table == 'iparks'){
            $query = Ipark::query();
        }
        // $query = DB::table($table)->select(['id','name']);

        if($filterColumn && $request->filled($filterId)){
            $query->where($filterColumn, $request->input($filterId));
        }
        // dd($request->input('search'));
        if($request->filled('search')){
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        return $query->get()->toArray();
    }

    public function province(Request $request)
    {
        $data = $this->getData($request, 'provinces');
        return ApplicationService::responseFormat(['provinces' => $data]);
    }

    public function city(Request $request)
    {
        $data = $this->getData($request, 'cities', 'province_id', 'province');
        return ApplicationService::responseFormat(['cities' => $data]);
    }

    public function ipark(Request $request){
        $data = $this->getData($request, 'iparks', 'province_id', 'province');
        return ApplicationService::responseFormat(['iparks' => $data]);
    }

    public function freezone(Request $request){
        $data = $this->getData($request, 'freezones', 'province_id', 'province');
        return ApplicationService::responseFormat(['freezones' => $data]);
    }

    public function category(){
        if(isset($_GET['category'])){
            $categories = Category::where('parent_id' , $_GET['category'])->select(['name', 'id'])->get()->toArray();
            return ApplicationService::responseFormat(['categories' => $categories]);
        }else{
            $categories = Category::where('parent_id' , null)->select(['name', 'id'])->get()->toArray();
            return ApplicationService::responseFormat(['categories' => $categories]);
        }
    }

    public function brandTypes(){
        //$types = DB::table('brand_types')->select(['id', 'name'])->get()->toArray();
        $types = BrandType::query()->select(['id', 'name'])->get()->toArray();
        return ApplicationService::responseFormat(['types' => $types]);
    }
}
