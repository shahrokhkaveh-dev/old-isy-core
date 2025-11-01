<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\sendBrandInformationRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Document;
use App\Models\Permission;
use App\Models\Province;
use App\Services\Application\ApplicationService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $phone = $request->input('phone');
        if (empty($phone) || !preg_match('/^(\\+98|0)?9\\d{9}$/', $phone)) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_mobile_number'), -1);
        }
        $userCheck = User::where('phone', $phone)->first();
        if ($userCheck) {
            return ApplicationService::responseFormat([], false, __('messages.user_already_exists'), -2);
        }
        $code = rand(1000, 9999);
        $token = Token::where('phone', $phone)->latest()->first();
        if ($token && !$token->isExpired()) {
            return ApplicationService::responseFormat([], false, __('messages.code_already_sent'), -3);
        }
        $token = Token::create([
            'phone' => $phone,
            'code' => $code,
            'expired_time' => Carbon::now()->addMinutes(2)
        ]);
        SMSPattern::sendOtp($phone, $code);
        return ApplicationService::responseFormat([], true, __('messages.code_sent_successfully'));
    }

    public function doRegister(Request $request): \Illuminate\Http\JsonResponse
    {
        $phone = $request->input('phone');
        if (empty($phone) || !preg_match('/^(\\+98|0)?9\\d{9}$/', $phone)) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_mobile_number'));
        }
        $code = $request->input('code');
        if (empty($code) || !is_numeric($code) || $code < 1000 || $code > 9999) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_code'));
        }
        $user = User::where('phone', $phone)
        ->when($request->input('nationality_code'),function ($q) use ($request) {return $q->where('nationality_code',$request->input('nationality_code'));})
        ->first();
        if ($user) {
            return ApplicationService::responseFormat([], false, __('messages.user_already_exists'));
        }
        $token = Token::where('phone', $request->input('phone'))->latest()->first();
        if (!$token) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_code'));
        }
        if ($token->isExpired() || $token->used) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_code'));
        }
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        if (empty($first_name) || empty($last_name)) {
            return ApplicationService::responseFormat([], false, __('messages.please_fill_all_fields'));
        }
        $province_id = $request->input('province_id');
        $city_id = $request->input('city_id');
        if (!empty($province_id)) {
            if(Province::find($province_id) == null){
                return ApplicationService::responseFormat([], false, __('messages.invalid_province'));
            }
        }
        if (!empty($city_id)) {
            if(City::find($city_id) == null){
                return ApplicationService::responseFormat([], false, __('messages.invalid_city'));
            }
        }
        $token->update([
            'used' => true
        ]);
        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'name' => $first_name . ' ' . $last_name,
            'phone' => $phone,
            'is_branding' => false,
            'brand_id' => null,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'nationaliy_code' => $request->input('nationality_code')
        ]);
        // create and login sanctum token
        $appToken = $user->createToken('application')->plainTextToken;
        return ApplicationService::responseFormat([
            'token' => $appToken
        ], true, __('messages.registration_successful'));
    }

    public function completeRegister(sendBrandInformationRequest $request)
    {
        $inputs = $request->all();
        $inputs['freezone_id'] = isset($inputs['freezone_id']) ? $inputs['freezone_id']: null;
        $user = Auth::guard('sanctum')->user();
        $brand = $user->brand;
        if ($brand) {
            $brand->update([
                'name' => $inputs['company_name'],
                'nationality_code' => $inputs['company_code'],
                'register_code' => $inputs['company_register'],
                'post_code' => $inputs['company_postCode'],
                'phone_number' => $inputs['company_phone'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'ipark_id' => $inputs['ipark_id'],
                'freezone_id' => $inputs['freezone_id'],
                'address' => $inputs['address'],
                'type' => $inputs['type'],
                'category_id' => $inputs['category_id'],
                'lat' => $inputs['lat'] ?? null,
                'lng' => $inputs['lng'] ?? null,
            ]);
            if ($request->file('Ncard')) {
                $NcardName = time() . random_int(1000, 9999) . '.' . $request->file('Ncard')->getClientOriginalExtension();
                $request->file('Ncard')->move('upload/documents/', $NcardName);
                $NcardPath = 'upload/documents/' . $NcardName;
            }
            if ($request->file('Newspaper')) {
                $NewspaperName = time() . random_int(1000, 9999) . '.' . $request->file('Newspaper')->getClientOriginalExtension();
                $request->file('Newspaper')->move('upload/documents/', $NewspaperName);
                $NewspaperPath = 'upload/documents/' . $NewspaperName;
            }
            $lastChangePath = null;
            if ($request->file('lastChange')) {
                $lastChangeName = time() . random_int(1000, 9999) . '.' . $request->file('lastChange')->getClientOriginalExtension();
                $request->file('lastChange')->move('upload/documents/', $lastChangeName);
                $lastChangePath = 'upload/documents/' . $lastChangeName;
            }
            Document::create([
                'brand_id' => $brand->id,
                'ncard' => $NcardPath,
                'newspaper' => $NewspaperPath,
                'lastchange' => $lastChangePath
            ]);
            $user->update([
                'nationaliy_code' => $inputs['user_code'],
                'birthday' => $inputs['user_Byear'] . '/' . $inputs['user_Bmonth'] . '/' . $inputs['user_Bday'],
                'status' => 3
            ]);
        } else {
            $brand = Brand::create([
                'name' => $inputs['company_name'],
                'nationality_code' => $inputs['company_code'],
                'register_code' => $inputs['company_register'],
                'post_code' => $inputs['company_postCode'],
                'phone_number' => $inputs['company_phone'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'ipark_id' => $inputs['ipark_id'],
                'freezone_id' => $inputs['freezone_id'],
                'address' => $inputs['address'],
                'type' => $inputs['type'],
                'category_id' => $inputs['category_id'],
                'lat' => $inputs['lat'] ?? null,
                'lng' => $inputs['lng'] ?? null,
                'vip_expired_time' => Carbon::now()->addMonth(3),
            ]);
            $NcardPath = null;
            if ($request->file('Ncard')) {
                $NcardName = time() . random_int(1000, 9999) . '.' . $request->file('Ncard')->getClientOriginalExtension();
                $request->file('Ncard')->move('upload/documents/', $NcardName);
                $NcardPath = 'upload/documents/' . $NcardName;
            }
            $NewspaperPath = null;
            if ($request->file('Newspaper')) {
                $NewspaperName = time() . random_int(1000, 9999) . '.' . $request->file('Newspaper')->getClientOriginalExtension();
                $request->file('Newspaper')->move('upload/documents/', $NewspaperName);
                $NewspaperPath = 'upload/documents/' . $NewspaperName;
            }
            $lastChangePath = null;
            if ($request->file('lastChange')) {
                $lastChangeName = time() . random_int(1000, 9999) . '.' . $request->file('lastChange')->getClientOriginalExtension();
                $request->file('lastChange')->move('upload/documents/', $lastChangeName);
                $lastChangePath = 'upload/documents/' . $lastChangeName;
            }
            Document::create([
                'brand_id' => $brand->id,
                'ncard' => $NcardPath,
                'newspaper' => $NewspaperPath,
                'lastchange' => $lastChangePath
            ]);
            $user->update([
                'nationaliy_code' => $inputs['user_code'],
                'birthday' => $inputs['user_Byear'] . '/' . $inputs['user_Bmonth'] . '/' . $inputs['user_Bday'],
                'status' => 3,
                'is_branding' => true,
                'brand_id' => $brand->id
            ]);
            foreach (Permission::all() as $p) {
                DB::table('user_permissions')->insert([
                    'user_id' => $user->id,
                    'permission_id' => $p->id
                ]);
            }
        }
        return ApplicationService::responseFormat([], true, __('messages.registration_successful'));
    }
}
