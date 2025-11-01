<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\Fields as AdminFields;
use App\Enums\CommonEntries;
use App\Enums\CommonFields;
use App\Enums\IPark\Fields;
use App\Enums\Product\Entries;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class CheckProductsController extends Controller
{

    public function index()
    {
        $searchNameOrId = request(CommonFields::NAME_OR_ID);
        $company = request(Fields::COMPANY);
        $subCategory = request(Fields::SUB_CATEGORY);
        $status = request(CommonFields::STATUS);
        $fromDate = request(CommonFields::FROM_DATE);
        $toDate = request(CommonFields::TO_DATE);

        $products = Product::select([
            CommonFields::ID, CommonFields::CREATED_AT, Fields::IMAGE, Fields::NAME, Fields::HS_CODE, Fields::BRAND,
            CommonFields::STATUS
        ]);

        if ($company) {
            $products = $products->where(Fields::BRAND, $company);
        }

        if ($subCategory) {
            $products = $products->where(Fields::SUB_CATEGORY, $subCategory);
        }

        if ($status) {
            $products = $products->where(CommonFields::STATUS, $status);
        }

        if ($fromDate) {
            $gregorianFromDate = Jalalian::fromFormat('Y/m/d', $fromDate)->toCarbon();
            $products = $products->where(CommonFields::CREATED_AT, '>=', $gregorianFromDate);
        }

        if ($toDate) {
            $gregorianToDate = Jalalian::fromFormat('Y/m/d', $toDate)->toCarbon();
            $products = $products->where(CommonFields::CREATED_AT, '<=', $gregorianToDate);
        }


        if ($searchNameOrId) {
            $products = $products->where(function ($query) use ($searchNameOrId) {
                $query->where(CommonFields::NAME, 'like', '%' . $searchNameOrId . '%')
                    ->orWhere(CommonFields::ID, 'like', '%' . $searchNameOrId . '%');
            });
        }

        $products = $products->paginate(Entries::PER_PAGE);

        $subCategories = Category::select([
            CommonFields::ID, CommonFields::NAME
        ])->whereNotNull(CommonFields::PARENT_ID)->get();

        return view('admin.panel.check-products', compact(['products', 'subCategories']));
    }

    public function show($id)
    {
        $id = decrypt($id);
        $product = Product::where(CommonFields::ID, $id)
            ->select([
                CommonFields::ID, CommonFields::NAME, Fields::DESCRIPTION, Fields::CATEGORY, Fields::IMAGE,
                Fields::BRAND, Fields::HS_CODE, Fields::AUTHOR, CommonFields::CREATED_AT, CommonFields::STATUS
            ])
            ->first();

        return view('admin.panel.show-product', compact(['product']));
    }

    public function changeStatus($id, $status)
    {
        $id = decrypt($id);
        $description = request('description');
        $userId = auth(AdminFields::ADMIN_GUARD)->user()->id;
        $product = Product::where(CommonFields::ID, $id)->first();
        $productStatus = $product[CommonFields::STATUS];

        if ($productStatus == CommonEntries::CONFIRMED_STATUS) {
            return back()->with(CommonFields::ERROR, __('dashboard.product_is_already_reviewed'));
        }

        $product->update([
            CommonFields::STATUS => $status,
            CommonFields::REVIEWED_BY => $userId,
        ]);

        if ($description) {
            $product->rejectionReasons()->updateOrCreate([], ['description' => $description]);
        }

        if ($status == CommonEntries::REJECTED_STATUS) {
            return back()->with(CommonFields::SUCCESS, __('dashboard.success_product_rejected'));
        }

        return redirect()->route('admin.check.products')->with(CommonFields::SUCCESS,
            __('dashboard.success_product_confirmed'));
    }
}
