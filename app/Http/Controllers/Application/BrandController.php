<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\BrandAddMemberRequest;
use App\Http\Requests\Application\BrandChangeLogoRequest;
use App\Http\Requests\Application\BrandEditMemberRequest;
use App\Http\Requests\Application\BrandInsertImageRequest;
use App\Http\Requests\Application\BrandManagementRequest;
use App\Http\Requests\Application\BrandRemoveImageRequest;
use App\Http\Requests\Application\BrandUpdateRequest;
use App\Http\Requests\Application\EditMemberRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Province;
use App\Models\User;
use App\Services\Application\ApplicationService;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    // public function index()
    // {
    //     $user = \request()->user();
    //     $brand = $user->brand;
    //     $selectedIndexes = ['name', 'logo_path', 'nationality_code', 'register_code', 'phone_number', 'post_code', 'address', 'managment_name', 'managment_number', 'managment_profile_path', 'description', 'lat', 'lng'];
    //     $data = [];
    //     foreach ($selectedIndexes as $value) {
    //         $data['brand'][$value] = $brand[$value];
    //     }

    //     $province = Province::find($brand->province_id);
    //     $city = City::find($brand->city_id);
    //     $ipark = Ipark::find($brand->ipark_id);
    //     $data['brand']['province'] = $province ? $province->name : null;
    //     $data['brand']['city'] = $city ? $city->name : null;
    //     $data['brand']['ipark'] = $ipark ? $ipark->name : null;
    //     $data['brand']['category_name'] = $brand->category?->name;

    //     $images = DB::table('brand_images')->latest()->select(['image_path', 'title'])
    //         ->where('brand_id', '=', $brand->id)->get();
    //     $images = $images ? $images->toArray() : [];
    //     $data['images'] = $images;

    //     $users = DB::table('users')
    //         ->select(['users.id', 'users.first_name', 'users.last_name', 'users.name', 'users.email', 'users.phone', 'user_permissions.permission_id', 'permissions.name as permission_name'])
    //         ->leftJoin('user_permissions', 'users.id', '=', 'user_permissions.user_id')
    //         ->leftJoin('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
    //         ->where('users.brand_id', $brand->id)
    //         ->get();

    //     foreach ($users as $user) {
    //         if (isset($data['users'][$user->phone])) {
    //             $data['users'][$user->phone]['permissions'][$user->permission_id] = $user->permission_name;
    //         } else {
    //             $data['users'][$user->phone]['id'] = encrypt($user->id);
    //             $data['users'][$user->phone]['first_name'] = $user->first_name;
    //             $data['users'][$user->phone]['last_name'] = $user->last_name;
    //             $data['users'][$user->phone]['name'] = $user->name;
    //             $data['users'][$user->phone]['email'] = $user->email;
    //             $data['users'][$user->phone]['phone'] = $user->phone;
    //             $data['users'][$user->phone]['permissions'][$user->permission_id] = $user->permission_name;
    //         }
    //     }
    //     $data['usersArray'] = array_values($data['users']);
    //     return ApplicationService::responseFormat($data);
    // }
    public function index()
    {
        // دریافت زبان فعلی
        $currentLocale = app()->getLocale();

        // دریافت کاربر فعلی
        $user = request()->user();

        // بارگذاری برند با تمام روابط مورد نیاز در یک کوئری
        $brand = $user->brand()->with([
            'translation', // ترجمه برند
            'province.translation', // ترجمه استان
            'city.translation', // ترجمه شهر
            'ipark.translation', // ترجمه پارک صنعتی
            'category.translation', // ترجمه دسته‌بندی
            'brandImages' => function($query) {
                $query->select('brand_id', 'image_path', 'title')->latest();
            },
            'users' => function($query) {
                $query->select('id', 'first_name', 'last_name', 'name', 'email', 'phone', 'brand_id');
            },
            'users.permissions' => function($query) {
                $query->select('permissions.id', 'permissions.name');
            }
        ])->first();

        if (!$brand) {
            return ApplicationService::responseFormat([], false, 'Brand not found', -1);
        }

        // فیلدهای قابل ترجمه برند
        $selectedIndexes = ['name', 'logo_path', 'nationality_code', 'register_code', 'phone_number', 'post_code', 'address', 'managment_name', 'managment_number', 'managment_profile_path', 'description', 'lat', 'lng'];

        $data = [];
        foreach ($selectedIndexes as $value) {
            // استفاده از ترجمه اگر زبان غیر فارسی باشد
            $data['brand'][$value] = $currentLocale === 'fa'
                ? $brand->{$value}
                : ($brand->translation->{$value} ?? $brand->{$value});
        }

        // افزودن داده‌های ترجمه شده مدل‌های مرتبط
        $data['brand']['province'] = $brand->province ? (
            $currentLocale === 'fa'
                ? $brand->province->name
                : ($brand->province->translation->name ?? $brand->province->name)
        ) : null;

        $data['brand']['city'] = $brand->city ? (
            $currentLocale === 'fa'
                ? $brand->city->name
                : ($brand->city->translation->name ?? $brand->city->name)
        ) : null;

        $data['brand']['ipark'] = $brand->ipark ? (
            $currentLocale === 'fa'
                ? $brand->ipark->name
                : ($brand->ipark->translation->name ?? $brand->ipark->name)
        ) : null;

        $data['brand']['category_name'] = $brand->category ? (
            $currentLocale === 'fa'
                ? $brand->category->name
                : ($brand->category->translation->name ?? $brand->category->name)
        ) : null;

        // افزودن تصاویر برند
        $data['images'] = $brand->brandImages ? $brand->brandImages->toArray() : [];

        // پردازش کاربران و دسترسی‌های آنها
        $usersData = [];
        foreach ($brand->users as $user) {
            $phone = $user->phone;

            // اگر کاربر با این شماره تلفن قبلاً اضافه نشده باشد
            if (!isset($usersData[$phone])) {
                $usersData[$phone] = [
                    'id' => encrypt($user->id),
                    'first_name' => $currentLocale === 'fa'
                        ? $user->first_name
                        : ($user->translation->first_name ?? $user->first_name),
                    'last_name' => $currentLocale === 'fa'
                        ? $user->last_name
                        : ($user->translation->last_name ?? $user->last_name),
                    'name' => $currentLocale === 'fa'
                        ? $user->name
                        : ($user->translation->first_name ?? $user->first_name) . ' ' . ($user->translation->last_name ?? $user->last_name),
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'permissions' => []
                ];
            }

            // افزودن دسترسی‌های کاربر
            foreach ($user->permissions as $permission) {
                $usersData[$phone]['permissions'][$permission->id] = $permission->translation->name;
            }
        }

        $data['users'] = $usersData;
        $data['usersArray'] = array_values($usersData);

        return ApplicationService::responseFormat($data);
    }

    public function changeLogo(BrandChangeLogoRequest $request)
    {
        $user = \request()->user();
        $brand = $user->brand;
        if ($brand->logo_path) {
            unlink($brand->logo_path);
        }
        $path = ImageService::upload($request->file('image'));
        $brand->update([
            'logo_path' => $path
        ]);
        return ApplicationService::responseFormat(['path' => $path], true, __('messages.logo_changed_successfully'));
    }

    public function insertImage(BrandInsertImageRequest $request)
    {
        $user = \request()->user();
        $brand = $user->brand;
        $path = ImageService::upload($request->file('image'));
        DB::table('brand_images')->insert([
            'brand_id' => $brand->id,
            'image_path' => $path,
            'title' => $request->input('title') ?? null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return ApplicationService::responseFormat(['path' => $path], true, __('messages.image_added_successfully'));
    }

    public function removeImage(BrandRemoveImageRequest $request)
    {
        $user = \request()->user();
        $brand = $user->brand;
        $image = DB::table('brand_images')->where(['brand_id' => $brand->id, 'image_path' => $request->input('path')]);

        if (!$image->first()) {
            return ApplicationService::responseFormat([], false, __('messages.image_not_found'));
        } else {
            if (file_exists($request->input('path'))) {
                unlink($request->input('path'));
            }
            $image->delete();
        }
        return ApplicationService::responseFormat([], true, __('messages.image_removed_successfully'));
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
        ]);

        $user = \request()->user();
        $brand = $user->brand;
        $image = DB::table('brand_images')->where(['brand_id' => $brand->id, 'image_path' => $request->input('path')]);

        if (!$image->first()) {
            return ApplicationService::responseFormat([], false, __('messages.image_not_found'));
        } else {
            $image->update([
                'title' => $request->input('title')
            ]);
        }
        return ApplicationService::responseFormat([], true, __('messages.image_updated_successfully'));
    }

    public function addMember(BrandAddMemberRequest $request)
    {
        $admin = \request()->user();
        $user = \request()->user();
        $brand = $user->brand;
        $memberCount = User::where(['brand_id' => $brand->id, 'is_branding' => true])->count();

        if ($memberCount >= 100) {
            return ApplicationService::responseFormat([], false, __('messages.max_brand_users_reached'));
        }

        if(!$admin->myBrand && !$admin->is_admin)
        {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'));
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'phone' => $request->input('phone'),
            'is_branding' => true,
            'brand_id' => $brand->id,
            'status' => 4
        ]);

        if (is_array($request->input('permission'))) {
            foreach (array_keys($request->input('permission')) as $p) {
                DB::table('user_permissions')->insert([
                    'user_id' => $user->id,
                    'permission_id' => $p
                ]);
            }
        }

        $data = [
            'name' => $user->name,
            'phone' => $user->phone
        ];

        return ApplicationService::responseFormat($data, true, __('messages.user_added_successfully'));
    }

    public function editmember(BrandEditMemberRequest $request)
    {
        $admin = \request()->user();
        $brand = $admin->brand_id ? $admin->brand : null;

        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -2);
        }
        if(!$admin->myBrand && !$admin->is_admin)
        {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'));
        }

        $user = User::findOrFail(decrypt($request->input('user_id')));

        if ($user->brand_id != $brand->id) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_belong_to_brand'), -2);
        }

        DB::table('user_permissions')->where('user_id', $user->id)->delete();
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'phone' => $request->input('phone'),
        ]);


        foreach (array_keys($request->input('permission')) as $p) {
            DB::table('user_permissions')->insert([
                'user_id' => $user->id,
                'permission_id' => $p
            ]);
        }

        $data = [
            'name' => $user->name,
            'phone' => $user->phone
        ];

        return ApplicationService::responseFormat($data, true, __('messages.user_updated_successfully'));
    }

    public function removeMember(Request $request)
    {
        $admin = \request()->user();
        $brand = $admin->brand_id ? $admin->brand : null;
        if(!$admin->myBrand)
        {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'));
        }

        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -2);
        }

        $user = User::findOrFail(decrypt($request->input('user_id')));

        if ($user->brand_id != $brand->id) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_belong_to_brand'), -2);
        }

        DB::table('user_permissions')->where('user_id', $user->id)->delete();
        $user->update([
            'brand_id' => null,
            'is_branding' => false,
            'status' => 1
        ]);

        return ApplicationService::responseFormat([], true, __('messages.user_removed_successfully'));
    }

    public function management(BrandManagementRequest $request)
    {
        $inputs = [];
        if ($request->input('description')) {
            $inputs['description'] = $request->input('description');
        }
        if ($request->input('management_name')) {
            $inputs['managment_name'] = $request->input('management_name');
        }
        if ($request->input('management_number')) {
            $inputs['managment_number'] = $request->input('management_number');
        }
        if ($request->file('management_profile_image')) {
            $path = ImageService::upload($request->file('management_profile_image'));
            $inputs['managment_profile_path'] = $path;
        }

        $user = \request()->user();
        $brand = $user->brand;
        $brand->update($inputs);

        return ApplicationService::responseFormat([], true, __('messages.information_updated_successfully'));
    }

    public function edit(): \Illuminate\Http\JsonResponse
    {
        $user = \request()->user();

        if (!$user->{'is_branding'}) {
            return ApplicationService::responseFormat([], false, __('messages.you_are_real_person'), -1);
        }

        $brand = Brand::find(\request()->user()->brand_id);

        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -2);
        }

        $userCan = DB::table('user_permissions')
            ->where([
                'user_id' => $user->id,
                'permission_id' => 1
            ])->exists();

        if (!$userCan) {
            return ApplicationService::responseFormat([], false, __('messages.no_permission_to_edit_brand'), -3);
        }

        $selectedColumns = [
            'province_id',
            'city_id',
            'ipark_id',
            'name',
            'nationality_code',
            'register_code',
            'phone_number',
            'post_code',
            'address',
            'category_id',
            'managment_name',
            'managment_position',
            'description',
            'managment_number',
            'lat',
            'lng',
            'logo_path',
            'managment_profile_path'
        ];

        $filteredBrandData = $brand->only($selectedColumns);

        if (!empty($filteredBrandData['logo_path'])) {
            $filteredBrandData['logo_path'] = asset($filteredBrandData['logo_path']);
        }
        if (!empty($filteredBrandData['managment_profile_path'])) {
            $filteredBrandData['managment_profile_path'] = asset($filteredBrandData['managment_profile_path']);
        }

        $province = Province::where('id', $brand->province_id)->first();
        $city = City::where('id', $brand->city_id)->first();
        $ipark = Ipark::where('id', $brand->ipark_id)->first();

        $location = [
            'province' => $province ? $province->only(['id', 'name']) : null,
            'city' => $city ? $city->only(['id', 'name']) : null,
            'ipark' => $ipark ? $ipark->only(['id', 'name']) : null,
            'lat' => $brand->lat,
            'lng' => $brand->lng
        ];

        $data = [
            'brand' => $filteredBrandData,
            'location' => $location
        ];

        return ApplicationService::responseFormat($data, true);
    }

    public function update(BrandUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->user()->brand_id;
        $brand = Brand::findOrFail($id);

        $updatableColumns = [
            'province_id' => 'province_id',
            'city_id' => 'city_id',
            'ipark_id' => 'ipark_id',
            'name' => 'name',
            'nationality_code' => 'nationality_code',
            'register_code' => 'register_code',
            'phone_number' => 'phone_number',
            'post_code' => 'post_code',
            'address' => 'address',
            'category_id' => 'category_id',
            'management_name' => 'managment_name',
            'management_position' => 'managment_position',
            'description' => 'description',
            'management_number' => 'managment_number',
            'lat' => 'lat',
            'lng' => 'lng',
        ];

        foreach ($updatableColumns as $key => $value) {
            if ($request->input($key)) {
                $brand->{$value} = $request->input($key);
            }
        }

        if ($request->file('logo')) {
            $path = ImageService::upload($request->file('logo'));
            $brand->logo_path = $path;
        }

        if ($request->file('management_profile')) {
            $path = ImageService::upload($request->file('management_profile'));
            $brand->managment_profile_path = $path;
        }

        $brand->save();

        return ApplicationService::responseFormat([], true, __('messages.information_updated_successfully'));
    }

    function vipStatus(): \Illuminate\Http\JsonResponse
    {
        $user = auth('sanctum')->user();
        $brand = $user->brand;
        $vipExpiredTime = $brand->vip_expired_time ? formatDate($brand->vip_expired_time) : null;
        return response()->json([
            'vip_expired_time' => $vipExpiredTime
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $user = auth('sanctum')->user();
        $user->update([
            'brand_id' => null,
            'is_branding' => false,
        ]);
        return ApplicationService::responseFormat([], true, __('messages.logged_out_successfully'));
    }
}
