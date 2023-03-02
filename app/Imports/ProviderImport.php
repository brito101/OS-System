<?php

namespace App\Imports;

use App\Models\Provider;
use App\Models\Subsidiary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProviderImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Provider([
            'social_name' => $row['nome_social'],
            'alias_name' => $row['nome_fantasia'],
            'document_company' => $row["cnpj"],
            'document_company_secondary' => $row["insc_estadual"],
            'activity' => $row["ramo"],
            'contact' => $row['contato'],
            'function' => $row['funcao'],
            'email' => $row['email'],
            'telephone' => $row['telefone'],
            'cell' => $row['celular'],
            'average_delivery_time' => $row['tempo_entrega'],
            'payment_conditions' => $row['condicoes_pagamento'],
            'discounts' => $row['codicoes_desconto'],
            'products_offered' => $row['produtos_servicos'],
            'promotion_funds' => $row['recursos_promocionais'],
            'technical_assistance' => $row['assistencia_tecnica'],
            'total_purchases_previous_year' => $row['total_adquirido_ano_anterior'],
            'zipcode' => $row['cep'],
            'street' => $row['rua'],
            'number' => $row['numero'],
            'complement' => $row['complemento'],
            'neighborhood' => $row['bairro'],
            'city' => $row['cidade'],
            'state' => $row['uf'],
            'observations' => '<p>' . $row['observacoes'] . '</p>',
        ]);
    }

    public function rules(): array
    {
        return [
            'nome_social' => 'required|min:2|max:191',
            'nome_fantasia' => 'required|min:2|max:191',
            'cnpj' => 'nullable|min:11|max:20',
            'insc_estadual' => 'nullable|min:5|max:20',
            'ramo' => 'nullable|min:2|max:191',
            'contato' => 'nullable|min:2|max:191',
            'funcao' => 'nullable|min:2|max:191',
            'email' => 'nullable|min:8|max:100|email',
            'telefone' => 'nullable|min:8|max:25',
            'celular' => 'nullable|max:25',
            'tempo_entrega' => 'nullable|max:191',
            'condicoes_pagamento' => 'nullable|max:191',
            'codicoes_desconto' => 'nullable|max:191',
            'produtos_servicos' => 'nullable|max:191',
            'recursos_promocionais' => 'nullable|max:191',
            'assistencia_tecnica' => 'nullable|max:191',
            'total_adquirido_ano_anterior' => 'nullable|max:191',
            'cep' => 'nullable|min:8|max:13',
            'rua' => 'nullable|min:3|max:100',
            'numero' => 'nullable|min:1|max:100',
            'complemento' => 'nullable|max:100',
            'bairro' => 'nullable|max:100',
            'uf' => 'nullable|min:2|max:2',
            'cidade' => 'nullable|min:2|max:100',
            'observacoes' => 'nullable|max:4000000000',
        ];
    }
}
