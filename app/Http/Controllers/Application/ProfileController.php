<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ProfileChangeAvatarRequest;
use App\Http\Requests\Application\ProfileChangeBirthdayRequest;
use App\Http\Requests\Application\ProfileChangeEmailRequest;
use App\Http\Requests\Application\ProfileChangeNameRequest;
use App\Http\Requests\Application\ProfileChangePasswordRequest;
use App\Http\Requests\Application\ProfileChangePhoneRequest;
use App\Http\Requests\Application\ProfileChangeRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\Application\ApplicationService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \request()->user()->toArray();
        $selectedIndexes = ['first_name', 'last_name', 'email', 'phone', 'birthday', 'nationaliy_code', 'avatar'];
        $data = [];
        foreach ($selectedIndexes as $value) {
            $data[$value] = $user[$value];
        }
        return ApplicationService::responseFormat($data);
    }

    // public function reload()
    // {
    //     $user = User::whereId(\request()->user()->id)->with('brand')->first();
    //     $ability = \request()->user()->ability();
    //     $brand = $user->brand;
    //     $data = [
    //         'user' => [
    //             'id' => encrypt($user->id),
    //             'first_name' => $user->first_name,
    //             'last_name' => $user->last_name,
    //             'name' => $user->first_name . ' ' . $user->last_name,
    //             'email' => $user->email,
    //             'phone' => $user->phone,
    //             'is_branding' => $user->is_branding,
    //             'is_admin' => $user->is_admin,
    //             'brand_id' => encrypt($user->brand_id),
    //             'status' => $user->status,
    //             'birthday' => $user->birthday,
    //             'avatar' => $user->avatar,
    //             'ability' => $user->ability(),
    //         ],
    //         'brand' => $brand ? [
    //             'id' => encrypt($brand->id),
    //             'province' => $brand->province_id ? $brand->province->name : null,
    //             'city' => $brand->city_id ? $brand->city->name : null,
    //             'ipark' => $brand->ipark_id ? $brand->ipark->name : null,
    //             'name' => $brand->name,
    //             'nationality_code' => $brand->nationality_code,
    //             'register_code' => $brand->register_code,
    //             'phone_number' => $brand->phone_number,
    //             'post_code' => $brand->post_code,
    //             'address' => $brand->address,
    //             'logo_path' => $brand->logo_path,
    //             'status' => $brand->status,
    //             'slug' => $brand->slug,
    //             'url' => $brand->url,
    //             'category_id' => $brand->category ? $brand->category->name : null,
    //             'vip_expired_time' => $brand->vip_expired_time ? jdate($brand->vip_expired_time)->format('Y/m/d') : "",
    //             'type' => $brand->type,
    //             'managment_profile_path' => $brand->managment_profile_path,
    //             'managment_name' => $brand->managment_name,
    //             'managment_number' => $brand->managment_number,
    //             'description' => $brand->description,
    //             'wallet' => $brand->wallet,
    //         ] : (object) []
    //     ];
    //     return ApplicationService::responseFormat($data);
    // }
    public function reload()
    {
        // دریافت زبان فعلی
        $currentLocale = app()->getLocale();

        // بارگذاری کاربر با تمام روابط مورد نیاز در یک کوئری
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
        ->whereId(request()->user()->id)
        ->first();

        if (!$user) {
            return ApplicationService::responseFormat([], false, 'User not found', -1);
        }

        // ساختار پایه پاسخ (دقیقاً مشابه نسخه اصلی)
        $data = [
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
                'wallet' => $user->wallet,
                'refferal_code' => $user->referral_code,
                'is_manager' => $user->myBrand ? 1 : 0
            ],
            'brand' => (object) []
        ];

        // اگر برند وجود داشت، داده‌های چند زبانه برند را اضافه می‌کنیم
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
                'vip_expired_time' => $brand->vip_expired_time ? jdate($brand->vip_expired_time)->format('Y/m/d') : "",
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

        return ApplicationService::responseFormat($data);
    }

    public function changeName(ProfileChangeNameRequest $request)
    {
        $user = \request()->user();
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name') ? $request->input('last_name') : null;
        $name = $lastName ? "{$firstName} {$lastName}" : $firstName;
        $user->update(['first_name' => $firstName, 'last_name' => $lastName, 'name' => $name]);
        return ApplicationService::responseFormat([], true, __('messages.name_changed_successfully'));
    }

    public function changeEmail(ProfileChangeEmailRequest $request)
    {
        $user = \request()->user();
        $email = $request->input('email');
        $user->update(['email' => $email, 'email_verification_at' => null]);
        return ApplicationService::responseFormat([], true, __('messages.email_changed_successfully'));
    }

    public function changePhone(ProfileChangePhoneRequest $request)
    {
        $user = \request()->user();
        $phone = $request->input('phone');
        $user->update(['phone' => $phone, 'phone_verification_at' => null]);
        return ApplicationService::responseFormat([], true, __('messages.phone_changed_successfully'));
    }

    public function changeBirthday(ProfileChangeBirthdayRequest $request)
    {
        $user = \request()->user();
        $birthday = $request->input('birthday');
        $user->update(['birthday' => $birthday]);
        return ApplicationService::responseFormat([], true, __('messages.birthday_changed_successfully'));
    }

    public function changeAvatar(ProfileChangeAvatarRequest $request)
    {
        $user = \request()->user();
        if ($user->avatar) {
            if (file_exists($user->avatar)) {
                unlink($user->avatar);
            }
        }
        $path = ImageService::upload($request->file('image'));
        $user->update([
            'avatar' => $path
        ]);
        return ApplicationService::responseFormat([['path' => $path]], true, __('messages.avatar_changed_successfully'));
    }

    public function removeAvatar()
    {
        $user = \request()->user();
        if ($user->avatar) {
            if (file_exists($user->avatar)) {
                unlink($user->avatar);
            }
        }
        $user->update([
            'avatar' => null
        ]);
        return ApplicationService::responseFormat([[]], true, __('messages.avatar_removed_successfully'));
    }

    public function changePassword(ProfileChangePasswordRequest $request)
    {
        $user = \request()->user();
        $password = $request->input('password');
        $user->update(['password' => Hash::make($password)]);
        return ApplicationService::responseFormat([], true, __('messages.password_changed_successfully'));
    }

    public function updateProfile(Request $request)
    {
        // متد خالی است، نیازی به تغییر ندارد
    }

    public function wishlist()
    {
        try {
            $user = \request()->user();
            $wishlist = $user ? Wishlist::getList($user->id)->toArray() : [];
            $wishlist = array_column($wishlist, 'product_id');
            $products = Product::where(['products.status' => 1, 'products.deleted_at' => null])->whereIn('products.id', $wishlist)
                ->rightJoin('categories', 'products.category_id', '=', 'categories.id')
                ->rightJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->select(['products.slug', 'products.image', 'products.name', 'products.description', 'categories.name as category', 'brands.name as office_name'])
                ->get();

            if ($products) {
                $products = $products->toArray();
                $products = array_map(function ($product) {
                    return [
                        'slug' => $product['slug'],
                        'img' => $product['image'],
                        'name' => $product['name'],
                        'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($product['description']), 0, 150)), 'UTF-8'),
                        'category' => $product['category'],
                        'office_name' => $product['office_name'],
                    ];
                }, $products);
                return ApplicationService::responseFormat($products);
            } else {
                return ApplicationService::responseFormat([], true, __('messages.no_products_found'), 2);
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function wishlist2(Request $request)
    {
        $productsCollection = $request
        ->user()
        ->wishlistProducts()
        ->select('id', 'slug', 'name', 'image', 'description', 'category_id', 'brand_id')
        ->with([
            'translation:product_id,name,description',
            'category' => fn($q) => $q->select('id', 'name')->with('translation:category_id,name'),
            'brand' => fn($q) => $q->select('id', 'name')->with('translation:brand_id,name'),
        ])
        ->where('status', 1)
        ->get();

        if ($productsCollection->count() === 0)
        {
            return ApplicationService::responseFormat([], true, __('messages.no_products_found'), 2);
        }

        $formattedProducts = $productsCollection->map(function ($product) {
            $description = $product->translation ? $product->translation->description : $product->description;

            return [
                'slug' => $product->slug,
                'img' => $product->image,
                'name' => $product->translation ? $product->translation->name : $product->name,
                'caption' => mb_convert_encoding(html_entity_decode(substr(strip_tags($description), 0, 150)), 'UTF-8'),
                'category' => $product->category ? ($product->category->translation ? $product->category->translation->name : $product->category->name) : null,
                'office_name' => $product->brand ? ($product->brand->translation ? $product->brand->translation->name : $product->brand->name) : null,
            ];
        })
        ->toArray();

        return ApplicationService::responseFormat($formattedProducts);
    }

    public function permissions()
    {
        $abilities = \request()->user()->ability();
        return ApplicationService::responseFormat($abilities);
    }
}
