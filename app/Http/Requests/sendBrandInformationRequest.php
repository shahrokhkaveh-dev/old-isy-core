<?php

namespace App\Http\Requests;

use App\Services\Application\ApplicationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class sendBrandInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'company_name' => 'required|persian_alpha|max:100',
            'address' => 'nullable|string|max:120',
            'company_code' => ['nullable', 'numeric', Rule::unique('brands', 'nationality_code')],
            'company_register' => 'nullable|numeric|max_digits:10',
            'company_postCode' => 'nullable|numeric|ir_postal_code',
            // 'company_phone' => 'nullable|max:11',
            'company_phone' => 'nullable|numeric',
            // 'user_code' => 'nullable|ir_national_code',
            // 'user_Bday' => 'nullable|numeric|max:31',
            // 'user_Bmonth' => 'nullable|numeric|max:12',
            // 'user_Byear' => 'nullable|numeric|min:1250|max:1500',
            'user_code' => 'nullable|ir_national_code',
            'user_Bday' => 'nullable|numeric|max:31',
            'user_Bmonth' => 'nullable|numeric|max:12',
            'user_Byear' => 'nullable|numeric|min:1250|max:1500',
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:cities,id',
            'ipark_id' => 'nullable|exists:iparks,id',
            'freezone_id' => 'nullable|exists:freezones,id',
            'Ncard' => 'nullable|mimes:jpg,png,pdf,jpeg|max:1024',
            'Newspaper' => 'nullable|mimes:jpg,png,pdf,jpeg|max:1024',
            'lastChange' => 'mimes:jpg,png,pdf,jpeg|max:1024',
            'type' => 'required|exists:brand_types,id',
            'category_id' => 'required',
            // 'testing' => 'required',
        ];

        // اگر در حال update هستیم، باید خود رکورد فعلی را از بررسی یکتایی مستثنی کنیم
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['company_code'] = [
                'required',
                'numeric',
                Rule::unique('brands', 'nationality_code')->ignore($this->route('brand')),
            ];
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'));
        exit(0);
    }
}
