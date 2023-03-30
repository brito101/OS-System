<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'salary'  => $this->salary ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->salary))) : null,
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
            'name' => 'required|min:1|max:191',
            'alias_name' => 'nullable|max:191',
            'genre' => 'nullable|in:Cisgênero,Feminino,Masculino,Não Binário,Outros,Transgênero',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:4096|dimensions:max_width=4000,max_height=4000',
            'document_primary' => 'nullable|max:191',
            'document_secondary' => 'nullable|max:191',
            'driver_license' => 'nullable|max:191',
            'voter_registration' => 'nullable|max:191',
            'email' => 'nullable|max:191',
            'telephone' => 'nullable|max:25',
            'cell' => 'nullable|max:25',
            'zipcode' => 'nullable|max:13',
            'street' => 'nullable|max:100',
            'number' => 'nullable|max:100',
            'complement' => 'nullable|max:100',
            'neighborhood' => 'nullable|max:100',
            'state' => 'nullable|max:3',
            'city' => 'nullable|max:100',
            'marital_status' => 'nullable|in:Casado,Solteiro,União Estável,Viúvo',
            'spouse' => 'nullable|max:191',
            'sons' => 'nullable|integer|min:0',
            'bank' => 'nullable|max:191',
            'agency' => 'nullable|max:191',
            'account' => 'nullable|max:191',
            'role' => 'nullable|max:191',
            'salary' => 'nullable|numeric|between:0,999999999.999',
            'admission_date' => 'nullable|date_format:Y-m-d',
            'resignation_date' => 'nullable|date_format:Y-m-d',
            'reason_dismissal' => 'nullable|max:4000000000',
            'subsidiary_id' => 'nullable|exists:subsidiaries,id',
            'pix' => 'nullable|max:191'
        ];
    }

    public function messages()
    {
        return [
            'salary.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'birth_date.date_format' => 'Formato de data de aniverário inválido',
            'admission_date.date_format' => 'Formato de data de admissão inválido',
            'resignation_date.date_format' => 'Formato de data de demissão inválido',
        ];
    }
}
