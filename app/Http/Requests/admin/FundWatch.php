<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class FundWatch extends FormRequest
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
            'fund_code' => 'required',
            'preamble' => 'required',
            'team' => 'required',
            'philosophy' => 'required',
            'investment_style' => 'required',
            'composition_analysis_top' => 'required',
            'composition_analysis_bottom' => 'required',
            'feedback' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'fund_code.required'=>'Please select fund',
            'preamble.required'=>'Enter preamble',
            'team.required'=>'Enter Research Team Members',
            'philosophy.required'=>'Enter Fund Philosophy',
            'investment_style.required'=>'Enter Investment Style',
            'composition_analysis_top.required'=>'Enter Fund Composition Analysis ',
            'composition_analysis_bottom.required'=>'Enter Fund Composition Analysis',
            'feedback.required'=>'Enter feedback',
        ];
    }
}
