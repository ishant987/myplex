<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class AdsCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'heading'=>'required',
            'sub_heading'=>'required',
            'link'=>'required | url',
        ];
    }
    public function messages()
    {
        return[
            'heading.required'=>'Enter heading',
            'sub_heading.required'=>'Enter sub-heading',
            'link.required'=>'Enter link',
            'link.url'=>'Enter valid link',
        ];
    }
}
