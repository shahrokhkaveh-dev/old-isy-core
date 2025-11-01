<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidReferralCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyReferralCodeRequest;
use App\Models\Brand;
use App\Models\User;
use App\Models\UserReferral;
use App\Services\Application\ApplicationService;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    protected ReferralService $referralService;
    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }
    // getReferralStats
    public function getReferralStats(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);
        $referrals = $user->referrals()->with('referredUser:id,name', 'referrerBrand:id,name')->latest()->get();
        $brandStats = $referrals->groupBy('reffered_brand_id')->map(function ($group) {
            $brand = $group->first()->referredBrand;
            return [
                'brand_id' => $brand->id,
                'brand_name' => $brand->translation->name,
                'total_referrals' => $group->count(),
                'recent_referrals' => $group->take(5)->map(function ($referral) {
                    return [
                        'user_id' => $referral->referredUser->id,
                        'user_name' => $referral->referredUser->translation->name,
                        'joined_at' => (app()->getLocale() == 'fa-IR') ? jdate($referral->created_at)->toDateString() : $referral->created_at->toDateTimeString(),
                    ];
                })->values(),
            ];
        })->values();

        return ApplicationService::responseFormat([
            'referral_code' => $user->referral_code,
            'total_referrals' => $referrals->count(),
            'brand_stats' => $brandStats,
            'recent_referrals' => $referrals->take(10)->map(function ($referral) {
                return [
                    'user_id' => $referral->referredUser->id,
                    'user_name' => $referral->referredUser->name,
                    'brand_name' => $referral->referredBrand->name,
                    'joined_at' => (app()->getLocale() == 'fa-IR') ? jdate($referral->created_at)->toDateString() : $referral->created_at->toDateTimeString()
                ];
            })
        ]);
    }

    /**
     * دریافت آمار کلی دعوت‌ها (برای ادمین)
     */
    public function getGlobalStats(Request $request)
    {
        $this->authorize('viewGlobalStats', User::class);

        $totalUsers = User::count();
        $totalReferrals = UserReferral::count();
        $brandsWithReferrals = UserReferral::distinct('brand_id')->count();

        $topReferrers = User::withCount('referrals')
            ->orderBy('referrals_count', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_referrals' => $totalReferrals,
                'brands_with_referrals' => $brandsWithReferrals,
                'top_referrers' => $topReferrers->map(function ($user) {
                    return [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'referral_count' => $user->referrals_count,
                        'brand_name' => $user->brand ? $user->brand->name : null
                    ];
                })
            ]
        ]);
    }

    /**
     * ثبت کد معرف توسط کاربر
     */
    public function applyReferralCode(ApplyReferralCodeRequest $request)
    {
        try {
            $user = $request->user();
            $referrer = $this->referralService->applyRefferalCode(
                $user->id,
                Str::upper($request->input('refferal_code'))
            );

            return ApplicationService::responseFormat([
                'success' => true,
                'message' => 'کد معرف با موفقیت ثبت شد',
                'referrer' => [
                    'id' => $referrer->id,
                    'name' => $referrer->name,
                    'brand' => $referrer->brand?->name
                ]
            ]);
        } catch (InvalidReferralCodeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
