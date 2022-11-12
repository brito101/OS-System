<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
            'day' => $this->day ? Carbon::createFromFormat('d/m/Y', $this->day)->format('Y-m-d') : date('Y-m-d'),
            'validity' => $this->validity && $this->validity != 'Interminado' ? Carbon::createFromFormat('d/m/Y', $this->validity)->format('Y-m-d') : null,
            'input' => (int) $this->input,
            'output' => (int)$this->output,
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
            'product_id' => 'required|exists:products,id',
            'day' => 'required|date_format:Y-m-d',
            'validity' => 'nullable|date_format:Y-m-d',
            'value' => 'required|numeric|between:0,999999999.999',
            'input' => 'nullable|integer',
            'output' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'day.date_format' => 'Formato de data inválido',
            'validity.date_format' => 'Formato de data inválido',
        ];
    }
}
