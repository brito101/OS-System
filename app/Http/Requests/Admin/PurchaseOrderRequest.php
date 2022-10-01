<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
            'date' => $this->date ? Carbon::createFromFormat('d/m/Y', $this->date)->format('Y-m-d') : null,
            'authorized_date' => $this->authorized_date ? Carbon::createFromFormat('d/m/Y', $this->authorized_date)->format('Y-m-d') : null,
            'forecast' => $this->forecast ? Carbon::createFromFormat('d/m/Y', $this->forecast)->format('Y-m-d') : null,
            'authorized_date' => $this->authorized_date ? Carbon::createFromFormat('d/m/Y', $this->authorized_date)->format('Y-m-d') : null,
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
            'subsidiary_id' => 'required|exists:subsidiaries,id',
            'date' => 'nullable|date_format:Y-m-d',
            'job' => 'required|max:191',
            'provider_id' => 'required|exists:providers,id',
            'invoice' => 'required|max:191',
            'amount' => 'required|integer|min:1|max:99999999',
            'value' => 'required|numeric|between:0,999999999.999',
            'requester' => 'required|max:191',
            'forecast' => 'nullable|date_format:Y-m-d',
            'authorized' => 'required|max:191',
            'authorized_date' => 'nullable|date_format:Y-m-d',
            'freight' => 'nullable|max:191',
            'purchase_mode' => 'required|max:191',
            'status' => 'nullable|in:executada,não executada',
            'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,zip|max:20480'
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'authorized_date.date_format' => 'Formato de data inválido',
            'forecast.date_format' => 'Formato de data inválido',
        ];
    }
}
