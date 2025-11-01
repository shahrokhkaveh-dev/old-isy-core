<?php

namespace App\Http\Requests\Application;

use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class BrandUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('sanctum')->user();
        if(!$user->{'is_branding'}){
            return false;
        }
        $brandPermission = 1;
        $userCan = DB::table('user_permissions')
            ->where([
                'user_id' => $user->id,
                'permission_id' => $brandPermission
            ])->exists();
        if(!$userCan){
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = auth('sanctum')->user();
        $id = $user->brand->id;
        return [
            'province_id'=>['nullable','exists:provinces,id'],
            'city_id'=>['nullable','exists:cities,id'],
            'ipark_id' => ['nullable','exists:iparks,id'],
            'name'=>['nullable','string', 'max:255', 'persian_alpha'],
            'nationality_code'=>['nullable','ir_company_id','max:11','unique:brands,nationality_code,'.$id],
            'register_code'=> ['nullable','string', 'max:10'],
            'phone_number' => ['nullable','string', 'max:11'],
            'post_code' => ['nullable','string', 'max:10','ir_postal_code'],
            'address' => ['nullable','string', 'max:120'],
            'logo' => ['nullable','mimes:jpeg,jpg,png,webp'],
            'category_id' => ['nullable','exists:categories,id'],
            'management_profile' => ['nullable','image'],
            'management_name' => ['nullable','string', 'max:255'],
            'management_position' => ['nullable','string', 'max:255'],
            'description' => ['nullable','string', 'max:1500'],
            'management_number' => ['nullable','string', 'max:11','ir_mobile'],
            'lat'=>['nullable','string', 'max:255'],
            'lng'=>['nullable','string', 'max:255'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    #[NoReturn] protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'));
        exit(0);
    }
}
