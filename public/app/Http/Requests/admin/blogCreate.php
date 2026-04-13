<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class blogCreate extends FormRequest
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
            'category' => 'required',
            'description' => 'required',
            'author' => 'required',
            'heading' => 'required',
            'sub_heading' => 'required',
            'tags' => 'required',
            'is_active' => 'required',
            'image_thumb' => 'required_without:image_thumb_old|mimes:jpg,jpeg,png|max:1024',
            'image_banner' => 'required_without:image_banner_old|mimes:jpg,jpeg,png|max:1024',
            'cta_required_url' => 'required_if:cta_required,==,1',
            
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Enter a title.',
            'description.required' => 'Enter a description.',
            'url.required' => 'Enter the blog URL.',
            'author.required' => 'Enter the author name.',
            'sub_heading.required' => 'Enter the heading.',
            'heading.required' => 'Enter the sub-heading.',
            'tags.required' => 'Enter the tags.',
            'is_active.required' => 'Select a status.',
            'image_thumb.required_without' => 'Select an thumb image',
            'image_thumb.max' => 'Max allowed space is 1MB',
            'image_thumb.mimes' => 'Only the JPEG,JPG,PNG formats available',
            'image_banner.required_without' => 'Select an thumb image',
            'image_banner.max' => 'Max allowed space is 1MB',
            'image_banner.mimes' => 'Only the JPEG,JPG,PNG formats available',
            'cta_required_url.required' => 'Enter the CTA url',
        ];
    }
}
