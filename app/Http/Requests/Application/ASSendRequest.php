<?php

namespace App\Http\Requests\Application;

use App\Models\Group;
use App\Services\Application\ApplicationService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ASSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->input('reciver_type') && $this->input('reciver_type') == 2){
            $groups = Group::where('brand_id' , \request()->user()->brand_id)->select(['id'])->get()->toArray();
            $groupsId = array_column($groups, 'id');
            $groupId = decrypt($this->input('reciver_id'));
            $result = (array_search($groupId , $groupsId) !== false);
            return $result;
        }
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
            "attachment" => 'max:1024|mimes:jpg,png,pdf|nullable',
            "reciver_id"=>'required',
            "reciver_type"=>'required',
            "subject"=>'required|max:250',
            "content"=>'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        header('Content-Type: application/json; charset=utf-8');
        echo ApplicationService::jsonFormat($errors, false, __('messages.invalid_form'));
        exit(0);
    }
}
