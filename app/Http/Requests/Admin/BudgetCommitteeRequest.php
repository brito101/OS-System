<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BudgetCommitteeRequest extends FormRequest
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
            'value'  => str_replace(',', '.', str_replace('.', '', $this->value)),
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
