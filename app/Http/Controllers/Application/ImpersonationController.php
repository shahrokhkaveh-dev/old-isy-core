<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class ImpersonationController extends Controller
{

    public function search($name)
    {
        if(!auth()->check() || !auth()->user()->is_admin){
            abort(403, 'Unauthorized action.');
        }

        $brands = \App\Models\Brand::where('name', 'like', '%' . $name . '%')
            ->orWhere('nationality_code', 'like', '%' . $name . '%')
            ->orWhere('id', $name)
            ->limit(10)
            ->select(['id', 'name'])
            ->get();
        return response()->json([
            'brands' => $brands,
            'message' => 'Brands found successfully.',
            'status' => true
        ])->setStatusCode(200);
    }

    public function doImpersonate(Request $request, $brandId)
    {
        if(!auth()->check() || !auth()->user()->is_admin){
            abort(403, 'Unauthorized action.');
        }

        $brand = \App\Models\Brand::find($brandId);
        if (!$brand) {
            return response()->json([
                'message' => 'Brand not found.',
                'status' => false
            ])->setStatusCode(404);
        }

        $user = \Auth::user();
        $user->update([
            'brand_id' => $brand->id,
            'is_branding' => 1
        ]);

        return response()->json([
            'message' => 'Impersonation successful.',
            'status' => true
        ])->setStatusCode(200);
    }
}
