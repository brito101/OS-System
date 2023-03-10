<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function true()
    {
        return false;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))),
            'tax'  => str_replace(',', '.', str_replace('.', '', str_replace(' %', '', $this->tax))),
            'commercial'  => str_replace(',', '.', str_replace('.', '', $this->commercial)),
            'fee'  => str_replace(',', '.', str_replace('.', '', $this->fee)),
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
            'code' => "required|min:1|max:191",
            'description' => 'required|min:1|max:191',
            'unity' => 'required|in:UN,Metro Linear,KM',
            'category' => 'required|in:Água,Gás,Geral,Hidrômetro,Sistema',
            'value' => 'required|numeric|between:0,999999999.999',
            'tax'  => 'required|numeric|between:0,100',
            'commercial' => 'required|numeric|between:0,999999999.999',
            'fee' => 'required|numeric|between:0,999999999.999',
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'tax.between' => 'O valor deve ser entre 0 e 100.',
            'commercial.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'fee.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
