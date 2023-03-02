<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TicketPaymentRequest extends FormRequest
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
            'total_value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value))),
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
            'employee' => 'required|min:1|max:191',
            'due_date' => 'required|date',
            'total_value' => 'required|numeric|between:0,999999999.999',
            'status' => 'required|in:pago,pendente',
            'observations' => 'nullable|max:40000',
            'subsidiary_id' => 'nullable|exists:subsidiaries,id',
        ];
    }

    public function messages()
    {
        return [
            'total_value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
