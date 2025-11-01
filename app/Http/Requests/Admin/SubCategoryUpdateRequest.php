<?php

namespace App\Http\Requests\Admin;

use App\Enums\Admin\Rules;
use App\Enums\CommonFields;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryUpdateRequest extends FormRequest
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
            CommonFields::ID => [Rules::REQUIRED, Rules::NUMERIC, Rules::SHOULD_EXIST_IN_CATEGORIES],
            CommonFields::PARENT_ID => [Rules::REQUIRED, Rules::NUMERIC, Rule::exists('categories', CommonFields::ID)->whereNull(CommonFields::PARENT_ID)],
            CommonFields::NAME => [Rules::REQUIRED, Rules::STRING, Rule::unique('categories', CommonFields::NAME)->where('parent_id', request(CommonFields::PARENT_ID))->ignore(request()->id),],
            CommonFields::DESCRIPTION => [Rules::NULLABLE, Rules::STRING],
        ];
    }
}
