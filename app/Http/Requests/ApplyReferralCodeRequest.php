<?php

namespace App\Http\Requests;

use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplyReferralCodeRequest extends FormRequest
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
            'refferal_code' => [
                'required',
                'string',
                'size:8',
                'exists:users,referral_code',
                'not_in:' . auth('sanctum')->user()->referral_code
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator){
            $user = $this->user();
            if($user->refferedBy()->exists()){
                $validator->errors()->add('referral_code', 'you have refferer!');
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
