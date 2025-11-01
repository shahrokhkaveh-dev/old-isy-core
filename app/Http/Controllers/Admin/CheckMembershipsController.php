<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Enums\Brand\Fields;
use App\Enums\CommonFields;
use App\Enums\Brand\Entries;
use App\Enums\CommonEntries;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Enums\Admin\Fields as AdminFields;

class CheckMembershipsController extends Controller
{
    public function index()
    {
        $perPage = $_GET[CommonFields::PER_PAGE] ?? 10;
        $brands = Brand::whereNot('name','بی نام')->whereNot(CommonFields::STATUS, CommonEntries::CONFIRMED_STATUS)->select([
            CommonFields::ID, CommonFields::CREATED_AT, Fields::LOGO, Fields::NAME, CommonFields::STATUS
        ])->paginate($perPage);

        return view('admin.panel.check-memberships', compact(['perPage', 'brands']));
    }

    public function show($id)
    {
        $id = decrypt($id);
        $userId = auth(AdminFields::ADMIN_GUARD)->user()->id;
        $brand = Brand::where(CommonFields::ID, $id)
            ->select([
                CommonFields::ID, CommonFields::NAME, Fields::REGISTER_CODE, Fields::NATIONALITY_CODE, Fields::PROVINCE,
                Fields::CITY, Fields::CATEGORY, Fields::LOGO, Fields::PARK, Fields::PHONE_NUMBER, Fields::ADDRESS,
                Fields::POST_CODE
            ])
            ->first();
        $redisKey = 'user:' . $userId . ':brand:' . $id;

        if (Redis::exists($redisKey)) {
            if (Redis::get($redisKey) != $userId) {
                return back()->with(CommonFields::ERROR, __('dashboard.brand_is_reviewing_by_another_admin'));
            }
        }

        $secondsLater = Carbon::now()->addMinutes(Entries::PENDING_REVIEW_MINUTES)->timestamp - Carbon::now()->timestamp;
        Redis::setex($redisKey, $secondsLater, $userId);

        return view('admin.panel.show-membership-request', compact(['brand']));
    }

    public function changeStatus($id, $status)
    {
        $id = decrypt($id);
        $userId = auth(AdminFields::ADMIN_GUARD)->user()->id;
        $redisKey = 'user:' . $userId . ':brand:' . $id;
        $description = request('description');

        if (!Redis::exists($redisKey) || Redis::get($redisKey) != $userId) {
            return back()->with(CommonFields::ERROR, __('dashboard.brand_is_not_reviewed_by_you'));
        }

        $brand = Brand::where(CommonFields::ID, $id)->first();

        if ($brand[CommonFields::STATUS] == CommonEntries::CONFIRMED_STATUS) {
            return back()->with(CommonFields::ERROR, __('dashboard.membership_is_already_reviewed'));
        }

        $brand->update([
            CommonFields::STATUS => $status,
            CommonFields::REVIEWED_BY => $userId
        ]);

        if ($description) {
            $brand->rejectionReasons()->updateOrCreate([], ['description' => $description]);
        }

        return redirect()->route('admin.brands.index')->with(
            CommonFields::SUCCESS,
            __('dashboard.success_membership_request_confirmed')
        );
    }
}
