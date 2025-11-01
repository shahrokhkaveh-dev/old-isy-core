<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MobileLetterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->input('reciver_type') && $this->input('reciver_type') == 2){
            $groups = Group::where('brand_id' , Auth::user()->brand->id)->select(['id'])->get()->toArray();
            $groupsId = array_column($groups, 'id');
            $result = (array_search($this->input('reciver_id') , $groupsId) !== false);
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
}
