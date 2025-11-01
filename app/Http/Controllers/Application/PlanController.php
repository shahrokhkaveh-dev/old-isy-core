<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\sendBrandInformationRequest;
use App\Models\Brand;
use App\Models\Plan\Payment;
use App\Models\Plan\Plan;
use App\Models\User;
use App\Services\Gateway\Parsian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use voku\helper\ASCII;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class PlanController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $brand_type = auth('sanctum')->user()->brand;
        if($brand_type && $brand_type->type){
            $brand_type = $brand_type->type;
        }
        $plans = Plan::where('plan_type',$brand_type)->with('attributes:name')->get();
        return response()->json(['plans' => $plans]);
    }

    public function buy(Request $request)
    {
        $messages = [
            'plan_id.required' => __('messages.plan_id_required'),
            'plan_id.exists' => __('messages.plan_not_found'),
        ];

        $request->validate([
            'plan_id' => 'required|exists:plans,id'
        ], $messages);

        $plan = Plan::find($request->input('plan_id'));
        $brand = auth()->user()->brand;

        $finalPrice = $this->calculateFinalPrice($plan);

        $payment = Payment::create([
            'plan_id' => $plan->id,
            'brand_id' => $brand->id,
            'amount' => $finalPrice
        ]);

        return Parsian::planApi($payment);
    }

    public function printPrefactor($plan_id)
    {
        $plan = Plan::find($plan_id);
        if (!$plan) {
            return response()->json(['error' => __('messages.plan_not_found')], 404);
        }
        $company = auth()->user()->brand;
        $pdf = Pdf::loadView('prefactorpdf', compact(['company', 'plan']), [], ['format' => "A4-L"]);
        return $pdf->download(__('messages.prefactor') . '.pdf');
        // return view('prefactorpdf', compact(['company', 'plan']));
    }

    private function calculateFinalPrice(Plan $plan) : int
    {
        $originalPrice = $plan->price;
        $finalPrice = $originalPrice;

        if (is_null($plan->discount_type)) {
            return $finalPrice;
        }

        if (!is_null($plan->discount_expired_time) && now()->gt($plan->discount_expired_time)) {
            return $finalPrice;
        }

        if ($plan->discount_type == 0) {
            if ($plan->discont_percenet > 0) {

                $discountPercentage = min($plan->discont_percenet, $plan->max_discont_percenet ?? 100);

                $discountAmount = ($originalPrice * $discountPercentage) / 100;
                $finalPrice = $originalPrice - $discountAmount;
            }
        } elseif ($plan->discount_type == 1) {
            if ($plan->discont_const > 0) {
                $discountAmount = min($plan->discont_const, $originalPrice);
                $finalPrice = $originalPrice - $discountAmount;
            }
        }

        return max(0, (int)$finalPrice);
    }
}
