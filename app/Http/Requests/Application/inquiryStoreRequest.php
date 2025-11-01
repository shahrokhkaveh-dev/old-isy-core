<?php

namespace App\Http\Requests\Application;

use App\Services\Application\ApplicationService;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use JsonException;

class inquiryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
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
            'product_id' => 'required',
            'destination_id' => 'required',
            'number' => 'required|numeric',
            'unit' => 'required|string|max:25',
            'max_budget' => 'nullable|numeric',
            'description' => 'nullable|max:255'
        ];
    }
    public function attributes(): array
    {
        return [
            'product_id' => 'محصول',
            'destination_id' => 'شرکت',
            'number' => 'تعداد درخواستی',
            'unit' => 'واحد',
            'max_budget' => 'حداکثر بودجه',
            'description' => 'توضیحات'
        ];
    }
    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'A title is required',
    //         'body.required' => 'A message is required',
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'));
        exit(0);
    }
}
