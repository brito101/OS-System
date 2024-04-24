<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
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

    protected function prepareForValidation()
    {
        $this->merge([
            'value_per_apartment'  => $this->value_per_apartment ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value_per_apartment))) : null,
            'total_value'  => $this->total_value ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value))) : null,
            'status_sale' => $this->trade_status == 'Venda Realizada' ? $this->status_sale : null,
            'reason_refusal' => $this->trade_status == 'Recusado' ? $this->reason_refusal : null,
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
            'name' => 'required|min:2|max:100',
            'document_person' => "nullable|min:11|max:20|unique:clients,document_person,{$this->id},id,deleted_at,NULL",
            'document_registry' => "nullable|min:11|max:20",
            'email' => 'nullable|min:8|max:100|email',
            'telephone' => 'nullable|min:8|max:25',
            'cell' => 'nullable|max:25',
            'zipcode' => 'nullable|min:8|max:13',
            'street' => 'nullable|min:3|max:100',
            'number' => 'nullable|min:1|max:100',
            'complement' => 'nullable|max:100',
            'neighborhood' => 'nullable|max:100',
            'state' => 'nullable|min:2|max:2',
            'city' => 'nullable|min:2|max:100',
            'company' => 'nullable|max:65000',
            'observations' => 'nullable|max:4000000000',
            'service' => 'nullable|max:65000',
            'type' => 'nullable|in:Administradora,Construtora,Síndico Profissional,Condomínio Comercial,Condomínio Residencial,Síndico Orgânico,Parceiro,Indicação,Outros',
            'trade_status' => 'nullable|in:Prospect,Prospect com Interesse,Lead,Lead com Proposta,Lead Inativo,Contato Realizado,Vistoria Marcada,Aguardando Orçamento,Orçamento Enviado,Assembléia Marcada,Negociação,Venda Realizada,Cliente,Ex Cliente,Recusado,Restrito',
            'origin' => 'nullable|in:Google,oHub,SindicoNet,Cota Síndicos,Feira,Indicação,Outros',
            'apartments' => 'nullable|integer|min:0|max:9999',
            'contact' => 'nullable|max:65000',
            'subsidiary_id' => 'required|exists:subsidiaries,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'contact_function' => 'nullable|max:191',
            'value_per_apartment' => 'nullable|numeric|between:0,999999999.99',
            'total_value'  => 'nullable|numeric|between:0,999999999.99',
            'meeting' => 'nullable|date_format:Y-m-d',
            'status_sale' => 'required_if:trade_status,Venda Realizada|in:,Contrato em Confecção,Contrato Assinado,Aguardando PG,Entrada PG,Aguardando Vistoria para Obra,Início de Obra,Obra em andamento,Obra Finalizada,Obra Entregue,Início de Leitura',
            'reason_refusal' => 'required_if:trade_status,Recusado|max:191',
            'blocks' => 'nullable|integer|min:0|max:99999',
            'type_piping' => 'nullable|max:191',
            'pipe_diameter' => 'nullable|max:191',
            'pipe_space' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'value_per_apartment.between' => 'O valor deve ser entre 0 e 999.999.999,99.',
            'total_value.between' => 'O valor deve ser entre 0 e 999.999.999,99.',
        ];
    }
}
