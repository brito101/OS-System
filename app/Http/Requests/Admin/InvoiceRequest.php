<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'due_date' => $this->due_date ? Carbon::createFromFormat('d/m/Y', $this->due_date)->format('Y-m-d') : null,
            'entrance'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->entrance))),
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
            'subsidiary_id' => 'required',
            'description' => 'required|max:191',
            'category' => 'nullable|max:191',
            'value' => 'required|numeric|between:0,999999999.999',
            'entrance' => 'nullable|numeric|between:0,999999999.999',
            'due_date' => 'required|date_format:Y-m-d',
            'repetition' => 'nullable|in:única,semanal,mensal,anual',
            'quota' => 'nullable|integer',
            'status' => 'nullable|in:pago,pendente',
            'purchase_mode' => 'nullable|in:boleto,cartão de crédito,dinheiro,PIX,transferência',
            'annotation' => 'nullable|max:4000000000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,zip|max:20480',
            'provider_id' => 'nullable|exists:providers,id'
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'entrance.between' => 'A entrada deve ser entre 0 e 999.999.999,999.',
            'due_date.date_format' => 'Formato de data inválido',
        ];
    }
}
