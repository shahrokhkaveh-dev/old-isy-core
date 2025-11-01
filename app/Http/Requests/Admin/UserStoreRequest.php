<?php

namespace App\Http\Requests\Admin;

use App\Enums\Admin\Rules;
use App\Enums\CommonFields;
use App\Enums\User\Fields;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UserStoreRequest extends FormRequest
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
            Fields::FIRST_NAME_INPUT => [Rules::REQUIRED, Rules::STRING],
            Fields::LAST_NAME_INPUT => [Rules::REQUIRED, Rules::STRING],
            Fields::EMAIL => [Rules::NULLABLE, Rules::STRING],
            CommonFields::BRAND_ID => [Rules::NULLABLE, Rules::SHOULD_EXIST_IN_BRANDS],
            Fields::PHONE => [Rules::REQUIRED, Rules::MOBILE_REGEX_PATTERN],
            CommonFields::STATUS => [Rules::REQUIRED, Rules::INTEGER, Rules::SHOULD_BE_BETWEEN_ONE_TO_FOUR],
            Fields::PASSWORD => [Rules::REQUIRED, Rules::STRING, Rules::CONFIRMED, Rules::AT_LEAST_EIGHT_CHARACTERS],
            Fields::IMAGE => [Rules::NULLABLE, Rules::IMAGE],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
