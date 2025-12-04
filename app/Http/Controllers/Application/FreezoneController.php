<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;

class FreezoneController extends Controller
{
    public function mainBrands(Request $request)
    {
        $special = intval($request->get('special', 0));

        $brands = Brand::query()
            ->select([
                'id',
                'name',
                'slug',
                'freezone_id',
                'logo_path',
            ])
            ->with(
                [
                    'translation:brand_id,name'
                ]
            )
            ->where('category_id', 8117)
            ->whereNotNull('freezone_id')
            ->when($special === 1, fn($q) => $q->where('name', 'like', 'منطقه ویژه%'))
            ->when($special === 2, fn($q) => $q->where('name', 'like', 'منطقه آزاد%'))
            ->get();

        $freezone_ids = $brands->pluck('freezone_id')->unique()->toArray();

        $brands_count = Brand::select([
            'freezone_id',
            \DB::raw('count(*) as brands_count')
        ])
            ->whereIn('freezone_id', $freezone_ids)
            ->where('category_id', '!=', 8117)
            ->groupBy('freezone_id')
            ->get();

        $brandsArr = $brands->map(fn($brand) => [
            'id' => $brand->id,
            'slug' => $brand->slug,
            'logo_path' => $brand->logo_path,
            'name' => $brand->translation->name ?? $brand->name,
            'brands_count' => $brands_count->first(fn($item) => $item->freezone_id === $brand->freezone_id)?->brands_count ?? 0,
        ]);

        $data = collect($brandsArr)->sortByDesc('brands_count')->values()->all();

        return ApplicationService::responseFormat($data);
    }
}
