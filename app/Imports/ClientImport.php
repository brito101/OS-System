<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Seller;
use App\Models\Subsidiary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            'user_id' => Auth::user()->id,
            'seller_id' => Seller::where('name', $row['vendedor'])->first()->id ?? null,
            'contact_function' => $row['funcao_contato'],
            'value_per_apartment' =>  $row['valor_por_apartamento'],
            'total_value' => $row['valor_total'],
            'meeting' => $row['assembleia'],
            'status_sale' => $row['status_venda_realizada'],
            'reason_refusal' => $row['motivo_recusa'],
        ]);
    }

    public function prepareForValidation($data, $index)
    {
        $data['valor_por_apartamento'] =  $data['valor_por_apartamento'] ? str_replace(',', '.', $data['valor_por_apartamento']) : null;
        $data['valor_total'] =  $data['valor_total'] ? str_replace(',', '.', $data['valor_total']) : null;
        $data['assembleia'] = $data['assembleia'] ? Carbon::createFromFormat('d/m/Y', $data['assembleia'])->format('Y-m-d') : null;

        return $data;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|min:2|max:100',
            "cpf_cnpj" => 'nullable|min:11|max:20',
            'email' => 'nullable|min:8|max:100|email',
            'telefone' => 'nullable|min:8|max:25',
            'celular' => 'nullable|max:25',
            'cep' => 'nullable|min:8|max:13',
            'rua' => 'nullable|min:3|max:100',
            'numero' => 'nullable|min:1|max:100',
            'complemento' => 'nullable|max:100',
            'bairro' => 'nullable|max:100',
            'uf' => 'nullable|min:2|max:2',
            'cidade' => 'nullable|min:2|max:100',
            'empresa' => 'nullable|max:65000',
            'observacoes' => 'nullable|max:4000000000',
            'servico' => 'nullable|max:65000',
            'tipo' => 'nullable|in:Administradora,Construtora,Síndico Profissional,Condomínio Comercial,Condomínio Residencial,Síndico Orgânico,Parceiro,Indicação,Outros',
            'status' => 'nullable|in:Lead,Prospect,Prospect com Interesse,Cliente,Ex Cliente,Lead com Proposta,Lead Inativo,Recusado,Restrito',
            'origem' => 'nullable|in:Google,oHub,SindicoNet,Cota Síndicos,Feira,Indicação,Outros',
            'apartamentos' => 'nullable|integer|min:0|max:9999',
            'contato' => 'nullable|max:65000',
            'filial' => 'nullable|exists:subsidiaries,alias_name',
            'funcao_contato' => 'nullable|max:191',
            'valor_por_apartamento' => 'nullable|numeric|between:0,999999999.99',
            'valor_total'  => 'nullable|numeric|between:0,999999999.99',
            'assembleia' => 'nullable|date_format:Y-m-d',
            'status_venda_realizada' => 'nullable|in:,Contrato em Confecção,Contrato Assinado,Aguardando PG,Entrada PG,Aguardando Vistoria para Obra,Início de Obra,Obra em andamento,Obra Finalizada,Obra Entregue,Início de Leitura',
            'motivo_recusa' => 'nullable|max:191',
        ];
    }
}
