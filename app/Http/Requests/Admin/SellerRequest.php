<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'document_person' => 'required|min:14|max:14',
            'email' => "nullable|max:100",
            'photo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:4096|dimensions:max_width=4000,max_height=4000',
            'telephone' => 'nullable|min:8|max:25',
            'cell' => 'nullable|min:8|max:25',
        ];
    }
}
