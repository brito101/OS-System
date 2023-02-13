<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KanbanRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:191',
            'description' => 'max:191',
            'value' => 'required|numeric|between:0,999999999.999',
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
