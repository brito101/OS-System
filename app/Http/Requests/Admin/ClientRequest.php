<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|min:2|max:100',
            'document_person' => "nullable|min:11|max:20|unique:clients,document_person,{$this->id},id,deleted_at,NULL",
            'document_registry' => "nullable|min:11|max:20",
            'document_secondary' => 'nullable|max:100',
            'email' => 'required|min:8|max:100|email',
            'telephone' => 'required|min:8|max:25',
            'cell' => 'nullable|max:25',
            'zipcode' => 'required|min:8|max:13',
            'street' => 'required|min:3|max:100',
            'number' => 'required|min:1|max:100',
            'complement' => 'nullable|max:100',
            'neighborhood' => 'nullable|max:100',
            'state' => 'required|min:2|max:3',
            'city' => 'required|min:2|max:100',
            'company' => 'nullable|max:65000',
            'observations' => 'nullable|max:4000000000',
            'service' => 'nullable|max:65000',
            'type' => 'nullable|in:Cliente Padrão,Lead',
            'trade_status' => 'nullable|max:191',
        ];
    }
}
