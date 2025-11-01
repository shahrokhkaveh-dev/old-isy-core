<?php

namespace App\Http\Controllers\New;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function show(string $slug): \Illuminate\Http\JsonResponse
    {
        $brand = Brand::where('slug', $slug)->with(['category', 'province', 'city', 'ipark'])->first();
        if (!$brand)
        {
            abort(404);
        }
        $brand->logo_path = $brand->logo_path ? asset($brand->logo_path) : null;
        $brand->managment_profile_path = $brand->managment_profile_path ? asset($brand->managment_profile_path) : null;
//        dd($brand);
        $products = Product::where('brand_id', $brand->id)->get()
            ->map(function ($item) use ($brand) {
                $item->image = $item->image ? asset($item->image) : null;
                return $item;
            });
        $images = DB::table('brand_images')->where('brand_id', $brand->id)->get()
            ->map(function ($item) use ($brand) {
                $item->image_path = $item->image_path ? asset($item->image_path) : null;
                return $item;
            });
        return ApplicationService::responseFormat([
            'data' => [
                'brand' => $brand,
                'images' => $images,
                'products' => $products,
            ]
        ]);
    }
}
