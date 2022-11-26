<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
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
            'job_value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->job_value))),
            'percentage'  => str_replace(',', '.', str_replace('.', '', str_replace(' %', '', $this->percentage))),
            'total_value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value))),
            'due_date' => $this->due_date ? Carbon::createFromFormat('d/m/Y', $this->due_date)->format('Y-m-d') : date('Y-m-d'),
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
            'seller_id' => 'required|exists:sellers,id',
            'product'  => 'required|max:191',
            'job' => 'required|max:191',
            'job_value' => 'required|numeric|between:0,999999999.999',
            'percentage' => 'required|numeric|between:0,100',
            'total_value' => 'required|numeric|between:0,999999999.999',
            'due_date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:pago,pendente',
            'subsidiary_id' => 'required|exists:subsidiaries,id',
        ];
    }

    public function messages()
    {
        return [
            'job_value.between' => 'O valor da obra deve ser entre 0 e 999.999.999,999.',
            'total_value.between' => 'O valor total deve ser entre 0 e 999.999.999,999.',
            'percentage.between' => 'O valor do percentual de comissão ser entre 0 e 100.',
            'due_date.date_format' => 'Formato de data inválido',
        ];
    }
}
