<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationPrice;
use App\Models\Brand;
use App\Models\Plan\Plan;
use Carbon\Carbon;

class PriceController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'planId' => 'required|exists:plans,id',
            'orderId' => 'required|string|max:255',
            'packageName' => 'required|string|max:255',
            'productId' => 'required|string|max:255',
            'purchaseTime' => 'required|string|max:255',
            'purchaseState' => 'required|string|max:255',
            'developerPayload' => 'required|string|max:255',
            'purchaseToken' => 'required|string|max:255',
            'status' => 'required|in:failed,success'
        ]);

        $currentUser = auth('sanctum')->user();
        $brand = Brand::where('id', $currentUser->brand_id)->first();
        $plan = Plan::where('id', $data['planId'])->first();

        $data['userId'] = $currentUser->id;
        $data['brandId'] = $brand->id;
        $data['planId'] = $req->planId;

        $newPrice = ApplicationPrice::create($data);

        if ($data['status'] == 'success') {
            $brand->update([
                'vip_expired_time' => Carbon::now()->addMonth($plan->period),
                'plan_id' => $plan->id,
            ]);
            return response()->json(['message' => __('messages.purchase_success')]);
        }

        return response()->json(['message' => __('messages.purchase_failed')], 400);
    }
}
