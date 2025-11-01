<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonEntries;
use App\Enums\CommonFields;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Admin\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(BrandRepository $repository){
        $brands = $repository->search([]);
        [$categories , $iparks] = $repository->starterData();
        return view('admin.panel.brands.index' , compact('categories', 'iparks', 'brands'));
    }

    public function search()
    {
        $search = request(CommonFields::SEARCH_STRING);

        $brands = Brand::select([
            CommonFields::ID, CommonFields::NAME
        ]);

        if ($search) {
            $brands = $brands->where(CommonFields::NAME, 'like', "%{$search['term']}%")->limit(CommonEntries::PER_PAGE)->get();

            return response()->json($brands);
        }
    }




}
