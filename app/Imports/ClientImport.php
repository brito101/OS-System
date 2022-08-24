<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ClientImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Client([
            'name' => Str::limit($row['nome'] ?? 'Não informado', 100),
            'document_person' => Str::limit($row['cpf'], 20),
            'email' => Str::limit($row['e_mail'], 100),
            'telephone' => Str::limit($row['telefone'], 25),
            'cell' => Str::limit($row['celular'], 25),
            'zipcode' => Str::limit($row['cep'], 13),
            'street' => Str::limit($row['rua'], 100),
            'number' => Str::limit($row['numero'], 100),
            'complement' => Str::limit($row['complemento'], 100),
            'neighborhood' => Str::limit($row['bairro'], 100),
            'city' => Str::limit($row['cidade'], 100),
            'state' => Str::limit($row['uf'], 2),
            'company' => Str::limit($row['empresa'], 65000),
            'observations' => '<p>' . Str::limit($row['observacoes'], 4000000000) . '</p>',
            'service' => Str::limit($row['servico'], 65000),
            'trade_status' => Str::limit($row['status_negociacao'], 191),
            'type' => $row['tipo_cliente'] == 'Lead' ? 'Lead' : 'Cliente Padrão',
        ]);
    }
}
