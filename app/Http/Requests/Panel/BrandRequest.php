<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
          if(auth()->user()){
            if(!auth()->user()->is_branding && auth()->user()){
                return true;
            }
          }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'province_id'=>'required',
            'city_id'=>'required',
            'name'=>'required|persian_alpha',
            'nationality_code'=>'required|min:10000000000|max:99999999999|numeric',
            'economic_code'=>'required|numeric',
            'register_code'=>'required|numeric',
            'license_number'=>'required|numeric',
            'phone_number'=>'required|numeric',
            'post_code'=>'required|numeric',
            'address'=>'required|max:150'
        ];
    }
}
