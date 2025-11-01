<?php

namespace App\Http\Controllers\New;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show(string $slug): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('slug', $slug)->with(['brand', 'attributes'])->first();
        if(!$product) abort(404);
        $product->image = $product->image ? asset($product->image) : null;
        $product->brand->logo_path = $product->brand->logo_path ? asset($product->brand->logo_path) : null;
        $otherProducts = Product::where('brand_id', $product->brand->id)->where('id', '!=', $product->id)->inRandomOrder()->limit(10)->get()
        ->map(function ($item){
            $item->image = $item->image ? asset($item->image) : null;
            return $item;
        });
        return ApplicationService::responseFormat([
            'data' => [
                'product' => $product,
                'brand' => $product->brand,
                'otherProducts' => $otherProducts,
            ]
        ]);
    }
}
