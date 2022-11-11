<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:1|max:191',
            'description' => 'nullable|max:191',
            'unity' => 'nullable|max:191',
            'min_stock' => 'nullable|integer|min:-999999999|max:999999999',
            'max_stock' => 'nullable|integer|min:-999999999|max:999999999'
        ];
    }
}
