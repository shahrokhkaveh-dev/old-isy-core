<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\FirebaseToken;
use App\Models\Token;
use App\Models\User;
use App\Services\Application\ApplicationService;
use App\Services\Notifications\EmailService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        // dd(app()->getLocale());
        $messages = [
            'phone.required_without' => __('messages.mobile_or_email_required'),
            'phone.ir_mobile' => __('messages.invalid_mobile'),
            'email.required_without' => __('messages.mobile_or_email_required'),
            'email.email' => __('messages.invalid_email'),
        ];

        \request()->validate([
            'phone' => 'required_without:email|ir_mobile',
            'email' => 'required_without:phone|email',
        ], $messages);

        $phone = \request()->input('phone', null);
        $email = \request()->input('email', null);
        $user = User::query()
            ->when($email, fn ($q) => $q->where('phone', $phone))
            ->when($email, fn ($q) => $q->where('email', $email))
            ->first();

        if (!$user) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_found'), -2);
        }

        $token = Token::query()
            ->when($phone, fn ($q) => $q->where('phone', $phone))
            ->when($email, fn ($q) => $q->where('email', $email))
            ->latest()
            ->first();
        $code = rand(1000, 9999);

        if (($token && $token->expired_time < Carbon::now()) || !$token) {
            DB::table('tokens')->insert([
                'phone' => $phone,
                'email' => $email,
                'code' => $code,
                'expired_time' => Carbon::now()->addMinutes(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if($phone) {
                SMSPattern::sendOtp($phone, $code);
                return ApplicationService::responseFormat([], true, __('messages.sms_sent'));
            } else {
                EmailService::sendOtp($email, $code, 'login', app()->getLocale(), getMode() === 'freezone');
                return ApplicationService::responseFormat([], true, __('messages.email_sent'));
            }
        }

        return ApplicationService::responseFormat([], false, __('messages.sms_not_sent'), -3);
    }

    public function code()
    {
        $currentLocale = app()->getLocale();

        $messages = [
            'phone.required' => __('messages.phone_required'),
            'phone.ir_mobile' => __('messages.invalid_mobile'),
            'code.required' => __('messages.code_required'),
            'code.numeric' => __('messages.code_numeric'),
            'code.min' => __('messages.code_min'),
            'code.max' => __('messages.code_max'),
        ];

        \request()->validate([
            'phone' => 'required_without:email|ir_mobile',
            'email' => 'required_without:phone|email',
            'code' => 'required|numeric|min:1000|max:9999'
        ], $messages);

        $phone = \request()->input('phone');
        $email = \request()->input('email');
        $firebaseToken = \request()->input('firebase_token');
        // $user = User::where('phone', $phone)->first();
        $user = User::with([
            'translation', // ترجمه کاربر
            'brand' => function($query) {
                $query->with([
                    'translation', // ترجمه برند
                    'province.translation', // ترجمه استان
                    'city.translation', // ترجمه شهر
                    'ipark.translation', // ترجمه پارک صنعتی
                    'category.translation' // ترجمه دسته‌بندی
                ]);
            }
        ])
            ->when($phone, fn($q) => $q->where('phone', $phone))
            ->when($email, fn($q) => $q->where('email', $email))
            ->first();

        if (!$user) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_found'));
        }

        $token = Token::query()
            ->when($phone, fn($q) => $q->where('phone', $phone))
            ->when($email, fn($q) => $q->where('email', $email))
            ->latest()
            ->first();

        if ($token->code != \request()->input('code')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_code'));
        }

        if ($token && $token->expired_time < Carbon::now()) {
            return ApplicationService::responseFormat([], false, __('messages.code_expired'));
        }

        $abilities = $user->ability();

        if ($user->tokens()->exists()) {
            $user->tokens()->delete();
        }

        $user_token = $user->createToken('token_base_name', $abilities)->plainTextToken;

        if (!is_null($firebaseToken)) {
            $tokenQuery = FirebaseToken::query()->where('token', $firebaseToken);
            $tokenExists = $tokenQuery->exists();

            if ($tokenExists) {
                $tokenQuery->update(['user_id' => $user->id]);
            } elseif (!is_null($user->firebaseToken)) {
                $user->firebaseToken()->update(['token' => $firebaseToken]);
            } else {
                $user->firebaseToken()->create(['token' => $firebaseToken]);
            }
        }

        $data = [
            'personal_access_token' => $user_token,
            'user' => [
                'id' => encrypt($user->id),
                'first_name' => $currentLocale === 'fa' ? $user->first_name : ($user->translation->first_name ?? $user->first_name),
                'last_name' => $currentLocale === 'fa' ? $user->last_name : ($user->translation->last_name ?? $user->last_name),
                'name' => $currentLocale === 'fa'
                    ? $user->first_name . ' ' . $user->last_name
                    : ($user->translation->first_name ?? $user->first_name) . ' ' . ($user->translation->last_name ?? $user->last_name),
                'email' => $user->email,
                'phone' => $user->phone,
                'is_branding' => $user->is_branding,
                'is_admin' => $user->is_admin,
                'brand_id' => encrypt($user->brand_id),
                'status' => $user->status,
                'birthday' => $user->birthday,
                'avatar' => $user->avatar,
                'ability' => $user->ability(),
                'is_manager' => $user->myBrand ? 1 : 0
            ],
            'brand' => (object) []
        ];

        if ($user->brand) {
            $brand = $user->brand;

            // ساختار دقیقاً مشابه نسخه اصلی
            $data['brand'] = [
                'id' => encrypt($brand->id),
                'province' => $brand->province_id ? (
                    $currentLocale === 'fa'
                        ? $brand->province->name
                        : ($brand->province->translation->name ?? $brand->province->name)
                ) : null,
                'city' => $brand->city_id ? (
                    $currentLocale === 'fa'
                        ? $brand->city->name
                        : ($brand->city->translation->name ?? $brand->city->name)
                ) : null,
                'ipark' => $brand->ipark_id ? (
                    $currentLocale === 'fa'
                        ? $brand->ipark->name
                        : ($brand->ipark->translation->name ?? $brand->ipark->name)
                ) : null,
                'name' => $currentLocale === 'fa'
                    ? $brand->name
                    : ($brand->translation->name ?? $brand->name),
                'nationality_code' => $currentLocale === 'fa'
                    ? $brand->nationality_code
                    : ($brand->translation->nationality_code ?? $brand->nationality_code),
                'register_code' => $currentLocale === 'fa'
                    ? $brand->register_code
                    : ($brand->translation->register_code ?? $brand->register_code),
                'phone_number' => $currentLocale === 'fa'
                    ? $brand->phone_number
                    : ($brand->translation->phone_number ?? $brand->phone_number),
                'post_code' => $currentLocale === 'fa'
                    ? $brand->post_code
                    : ($brand->translation->post_code ?? $brand->post_code),
                'address' => $currentLocale === 'fa'
                    ? $brand->address
                    : ($brand->translation->address ?? $brand->address),
                'logo_path' => $currentLocale === 'fa'
                    ? $brand->logo_path
                    : ($brand->translation->logo_path ?? $brand->logo_path),
                'status' => $brand->status,
                'slug' => $brand->slug,
                'url' => $brand->url,
                'category_id' => $brand->category ? (
                    $currentLocale === 'fa'
                        ? $brand->category->name
                        : ($brand->category->translation->name ?? $brand->category->name)
                ) : null,
                'vip_expired_time' => $brand->vip_expired_time ? formatDate($brand->vip_expired_time) : null,
                'type' => $brand->type,
                'managment_profile_path' => $currentLocale === 'fa'
                    ? $brand->managment_profile_path
                    : ($brand->translation->managment_profile_path ?? $brand->managment_profile_path),
                'managment_name' => $currentLocale === 'fa'
                    ? $brand->managment_name
                    : ($brand->translation->managment_name ?? $brand->managment_name),
                'managment_number' => $currentLocale === 'fa'
                    ? $brand->managment_number
                    : ($brand->translation->managment_number ?? $brand->managment_number),
                'description' => $currentLocale === 'fa'
                    ? $brand->description
                    : ($brand->translation->description ?? $brand->description),
                'wallet' => $brand->wallet,
            ];
        }

        return ApplicationService::responseFormat($data, true, __('messages.login_success'));
    }
}
