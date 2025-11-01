<?php

namespace App\Http\Requests\Admin;

use App\Enums\Admin\Rules;
use App\Enums\CommonFields;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryDeleteRequest extends FormRequest
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
            CommonFields::ID => [
                Rules::REQUIRED, Rules::NUMERIC, Rules::SHOULD_EXIST_IN_CATEGORIES,
                Rules::CATEGORY_SHOULD_NOT_EXIST_IN_PRODUCTS, Rules::CATEGORY_SHOULD_NOT_BE_PARENT],
        ];
    }
}
