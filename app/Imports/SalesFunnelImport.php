<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\SalesFunnel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SalesFunnelImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new SalesFunnel([
            'client_id' => $row['cliente'],
            'description' => $row['produto_servico'],
            'proposal' => $row['valor_proposta'],
            'status' => $row['status_funil'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function prepareForValidation($data, $index)
    {
        $client = Client::where('name', $data['cliente'])->first();
        if ($client) {
            $data['cliente'] = $client->id;
        } else {
            $data['cliente'] = 0;
        }
        $data['valor_proposta'] = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $data['valor_proposta'])));

        return $data;
    }

    public function rules(): array
    {

        return [
            'cliente' => 'required|exists:clients,id',
            'produto_servico' => 'max:191',
            'valor_proposta' => 'required|numeric|between:0,999999999.999',
            'status_funil' => 'in:Visita Agendada,Vistoria Executada,Envio de Proposta,Negociação,Assembléia Marcada,Fechamento,Perdido'
        ];
    }
}
