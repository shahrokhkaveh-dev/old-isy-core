<?php

namespace App\Http\Requests\Application\Auth;

use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\NoReturn;

class SetFirebaseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firebase_token' => ['required'],
        ];
    }
    #[NoReturn] protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'), -1);
        exit(0);
    }
}
