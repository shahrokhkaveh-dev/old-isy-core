<?php

namespace App\Http\Requests\Application;

use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BrandManagementRequest extends FormRequest
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
        return [
            'description' => 'nullable|max:1000',
            'management_name' => 'nullable|persian_alpha|max:200',
            'management_number' => 'nullable|ir_mobile:zero|max:11',
            'management_profile_image' => 'nullable|image',
        ];
    }

    public function attributes()
    {
        return [
            'management_name' => 'نام نماینده',
            'management_number' => 'شماره نماینده',
            'management_profile_image' => 'تصویر نماینده',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'));
        exit(0);
    }
}
