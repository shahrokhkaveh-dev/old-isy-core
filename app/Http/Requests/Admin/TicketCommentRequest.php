<?php

namespace App\Http\Requests\Admin;

use App\Enums\Admin\Rules;
use App\Enums\TicketComment\Fields;
use Illuminate\Foundation\Http\FormRequest;

class TicketCommentRequest extends FormRequest
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
            Fields::COMMENT => [Rules::REQUIRED, Rules::STRING],
            Fields::FILE => [Rules::NULLABLE, Rules::FILE, Rules::FILE_MIMES, Rules::FILE_SIZE],
            Fields::UUID => [Rules::REQUIRED, Rules::UUID, Rules::UUID_SHOULD_EXISTS_IN_TICKETS],
            Fields::TICKET_ID => [Rules::REQUIRED, Rules::ID_SHOULD_EXISTS_IN_TICKETS]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            Fields::UUID => $this->route(Fields::UUID),
        ]);
    }
}
