<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\inquiryStoreRequest;
use App\Models\Product;
use App\Models\ProductInquery;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\Application\ApplicationService;
use App\Services\Notifications\FirebaseService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    public function store(inquiryStoreRequest $request)
    {
        $user = \request()->user();
        $destination_id = $request->input('destination_id');
        if (!is_numeric($destination_id)) {
            $destination_id = decrypt($destination_id);
        }
        $product_id = $request->input('product_id');
        if (!is_numeric($product_id)) {
            $product_id = decrypt($product_id);
        }

        $dailyLimit = ProductInquery::where('author_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->yesterday())
            ->count();

        if ($dailyLimit >= 10) {
            return ApplicationService::responseFormat([], false, __('messages.daily_limit_reached'), -2);
        }

        $productLimit = ProductInquery::where('author_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->yesterday())
            ->where('product_id', $product_id)
            ->first();

        if ($productLimit) {
            return ApplicationService::responseFormat([], false, __('messages.product_already_inquired'), -4);
        }

        try {
            $inquiry = ProductInquery::create([
                'author_id' => $user->id,
                'product_id' => $product_id,
                'brand_id' => $user->brand_id,
                'destination_id' => $destination_id,
                'number' => $request->input('number'),
                'unit' => $request->input('unit'),
                'max_budget' => $request->input('max_budget'),
                'description' => $request->input('description')
            ]);

            $receiver_users = User::select(['users.phone', 'users.avatar', 'users.id'])
                ->join('user_permissions', 'users.id', '=', 'user_permissions.user_id')
                ->where(['user_permissions.permission_id' => 5, 'users.brand_id' => $destination_id])
                ->get();

            if ($receiver_users) {
                $firebaseService = new FirebaseService();
                foreach ($receiver_users as $receiver) {
                    SMSPattern::sendInquery($receiver->phone, $user->brand->name);
                    $firebaseService->sendInquiryNotificationToUser($user, $receiver);
                }
            }
        } catch (\Throwable $th) {
            return ApplicationService::responseFormat([], false, __('messages.server_error'), -3);
        }

        return ApplicationService::responseFormat([], true, __('messages.inquiry_submitted_successfully'));
    }

    public function show(Request $request)
    {
        $user = \request()->user();

        if ($request->input('id') == null) {
            return ApplicationService::responseFormat([], false, __('messages.inquiry_id_required'), -2);
        }

        $inquiry = ProductInquery::where('product_inquiries.id', decrypt($request->input('id')))
            ->select([
                'product_inquiries.id', 'product_inquiries.number', 'product_inquiries.unit', 'product_inquiries.max_budget', 'product_inquiries.description', 'product_inquiries.created_at', 'product_inquiries.status', 'product_inquiries.amount', 'product_inquiries.response_description', 'product_inquiries.response_date', 'product_inquiries.prefactor_path',
                'author.name as author',
                'response.name as response_name',
                'product_inquiries.product_id', 'products.name as product_name', 'products.slug as product_slug', 'products.image as product_image',
                'product_inquiries.brand_id', 'brand.name as brand_name', 'brand.slug as brand_slug', 'brand.logo_path as brand_logo_path',
                'product_inquiries.destination_id', 'destination.name as destination_name', 'brand.slug as destination_slug', 'destination.logo_path as destination_logo_path',
            ])
            ->rightjoin('users as author', 'product_inquiries.author_id', '=', 'author.id')
            ->rightjoin('products', 'product_inquiries.product_id', '=', 'products.id')
            ->rightjoin('brands as brand', 'product_inquiries.brand_id', '=', 'brand.id')
            ->rightjoin('brands as destination', 'product_inquiries.destination_id', '=', 'destination.id')
            ->leftjoin('users as response', 'product_inquiries.responsor_id', '=', 'response.id')
            ->first();

        if (!$inquiry) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_inquiry_id'), -3);
        }

        if ($inquiry->brand_id != $user->brand_id && $inquiry->destination_id != $user->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'), -4);
        }

        $inquiry = $inquiry->toArray();
        $inquiry['id'] = encrypt($inquiry['id']);
        $inquiry['product_id'] = encrypt($inquiry['product_id']);
        $inquiry['brand_id'] = encrypt($inquiry['brand_id']);
        $inquiry['destination_id'] = encrypt($inquiry['destination_id']);
        $inquiry['created_at'] = jdate($inquiry['created_at'])->format('Y/m/d');
        $inquiry['response_date'] = $inquiry['response_date'] ? jdate($inquiry['response_date'])->format('Y/m/d') : null;

        $data['inquiry'] = $inquiry;

        return ApplicationService::responseFormat($data);
    }

    public function show2(Request $request)
    {
        $user = $request->user();

        if (!$request->filled('id')) {
            return ApplicationService::responseFormat([], false, __('messages.inquiry_id_required'), -2);
        }

        $inquiry = ProductInquery::with([
            'author:id,name',
            'responser:id,name',
            'product:id,name,slug,image',
            'brand:id,name,slug,logo_path',
            'destination:id,name,slug,logo_path'
        ])->find(decrypt($request->input('id')));

        if (!$inquiry) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_inquiry_id'), -3);
        }

        if ($inquiry->brand_id != $user->brand_id && $inquiry->destination_id != $user->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'), -4);
        }

        $inquiryArray = $inquiry->toArray();

        $currentLocale = app()->getLocale();

        $formattedInquiry = [
            'id' => encrypt($inquiryArray['id']),
            'number' => $inquiryArray['number'],
            'unit' => $inquiryArray['unit'],
            'max_budget' => $inquiryArray['max_budget'],
            'description' => $inquiryArray['description'],
            'created_at' => $currentLocale === 'fa-IR'
                ? jdate($inquiryArray['created_at'])->format('Y/m/d')
                : Carbon::parse($inquiryArray['created_at'])->format('Y-m-d'),
            'status' => $inquiryArray['status'],
            'amount' => $inquiryArray['amount'],
            'response_description' => $inquiryArray['response_description'],
            'response_date' => $inquiryArray['response_date']
                ? (
                $currentLocale === 'fa-IR'
                    ? jdate($inquiryArray['response_date'])->format('Y/m/d')
                    : Carbon::parse($inquiryArray['response_date'])->format('Y-m-d')
                )
                : null,
            'prefactor_path' => $inquiryArray['prefactor_path'],

            'author' => $inquiryArray['author']['name'],
            'response_name' => $inquiryArray['responser']['name'] ?? null,

            'product_id' => encrypt($inquiryArray['product_id']),
            'product_name' => $inquiryArray['product']['name'],
            'product_slug' => $inquiryArray['product']['slug'],
            'product_image' => $inquiryArray['product']['image'],

            'brand_id' => encrypt($inquiryArray['brand_id']),
            'brand_name' => $inquiryArray['brand']['name'],
            'brand_slug' => $inquiryArray['brand']['slug'],
            'brand_logo_path' => $inquiryArray['brand']['logo_path'],

            'destination_id' => encrypt($inquiryArray['destination_id']),
            'destination_name' => $inquiryArray['destination']['name'],
            'destination_slug' => $inquiryArray['destination']['slug'],
            'destination_logo_path' => $inquiryArray['destination']['logo_path'],
        ];

        return ApplicationService::responseFormat(['inquiry' => $formattedInquiry]);
    }
}
