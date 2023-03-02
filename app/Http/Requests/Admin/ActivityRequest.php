<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'duration' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'duration.date_format' => 'O campo duração deve ser no formato hh:mm.',
        ];
    }
}
