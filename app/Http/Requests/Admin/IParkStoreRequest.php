<?php

namespace App\Http\Requests\Admin;

use App\Enums\Admin\Rules;
use App\Enums\CommonFields;
use App\Models\Ipark;
use Illuminate\Foundation\Http\FormRequest;

class IParkStoreRequest extends FormRequest
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
            CommonFields::NAME => [Rules::REQUIRED, Rules::STRING],
            CommonFields::PROVINCE_ID => [Rules::REQUIRED, Rules::NUMERIC, Rules::SHOULD_EXIST_IN_PROVINCES],
            CommonFields::DESCRIPTION => [Rules::STRING],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $existingRecord = IPark::where(CommonFields::NAME, $this->input(CommonFields::NAME))
                ->where(CommonFields::PROVINCE_ID, $this->input(CommonFields::PROVINCE_ID))
                ->first();

            if ($existingRecord) {
                $validator->errors()->add('name', __('dashboard.this_name_for_this_province_already_exists'));
            }
        });
    }
}
