<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        // dd(\request()->method());
        return [
            'fname' => 'required|persian_alpha|max:40',
            'lname' => 'required|persian_alpha|max:40',
            'email' => 'required|email|unique:admins,email|max:50',
            'phone' => 'required|ir_mobile:zero|unique:admins,phone|max:11|min:11',
            'username' => 'required|max:20|alpha|unique:admins,username',
            'role' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'image' => 'nullable|max:1024|image'
        ];
    }
}
