<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Subsidiary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Client([
            'name' => $row['nome'],
            'document_person' => $row["cpf_cnpj"],
            'email' => $row['email'],
            'telephone' => $row['telefone'],
            'cell' => $row['celular'],
            'zipcode' => $row['cep'],
            'street' => $row['rua'],
            'number' => $row['numero'],
            'complement' => $row['complemento'],
            'neighborhood' => $row['bairro'],
            'city' => $row['cidade'],
            'state' => $row['uf'],
            'company' => $row['empresa'],
            'observations' => '<p>' . $row['observacoes'] . '</p>',
            'service' => $row['servico'],
            'trade_status' => $row['status'],
            'type' => $row['tipo'],
            'origin' => $row['origem'],
            'apartments' => $row['apartamentos'] ?? 0,
            'contact' => $row['contato'],
            'subsidiary_id' => Subsidiary::where('alias_name', $row['filial'])->first()->id ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|min:2|max:100',
            "cpf_cnpj" => 'required|min:11|max:20',
            'email' => 'required|min:8|max:100|email',
            'telefone' => 'required|min:8|max:25',
            'celular' => 'nullable|max:25',
            'cep' => 'required|min:8|max:13',
            'rua' => 'required|min:3|max:100',
            'numero' => 'required|min:1|max:100',
            'complemento' => 'nullable|max:100',
            'bairro' => 'required|max:100',
            'uf' => 'required|min:2|max:2',
            'cidade' => 'required|min:2|max:100',
            'empresa' => 'required|max:65000',
            'observacoes' => 'nullable|max:4000000000',
            'servico' => 'nullable|max:65000',
            'tipo' => 'required|in:Administradora,Construtora,Síndico Profissional,Condomínio Comercial,Condomínio Residencial,Síndico Orgânico,Parceiro,Indicação,Outros',
            'status' => 'required|in:Lead,Prospect,Cliente',
            'origem' => 'required|in:Google,oHub,SindicoNet,Cota Síndicos,Feira,Indicação,Outros',
            'apartamentos' => 'nullable|integer|min:0|max:9999',
            'contato' => 'nullable|max:65000',
            'filial' => 'nullable|exists:subsidiaries,alias_name'
        ];
    }
}
