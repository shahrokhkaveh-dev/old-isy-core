<?php

namespace App\Http\Requests\Application;

use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProdustStoreResponseRequest extends FormRequest
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
            'id' => ['required'],
            'status' => ['required'],
            'amount' => ['nullable', 'string', 'max:20'],
            'prefactor' => ['nullable', 'mimes:pdf' , 'max:2048'],
            'response_description' => ['nullable' , 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'شناسه',
            'status' => 'وضعیت',
            'amount' => 'مبلغ',
            'prefactor' => 'پیش‌فاکتور',
            'response_description' => 'پاسخ',
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
