<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Subsidiary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Employee([
            'name' => $row['nome'],
            'alias_name' => $row['nome_social'],
            'genre' => $row['genero'],
            'birth_date' => $row['data_nascimento'],
            'document_primary' => $row['cpf'],
            'document_secondary' => $row['rg'],
            'driver_license' => $row['cnh'],
            'voter_registration' => $row['titulo_eleitor'],
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
            'marital_status' => $row['estado_civil'],
            'spouse' => $row['conjuge'],
            'sons' => $row['filhos'],
            'bank'  => $row['banco'],
            'agency'  => $row['agencia'],
            'account' => $row['conta'],
            'role'  => $row['cargo'],
            'salary'  => $row['salario'],
            'admission_date' => $row['data_admissao'],
            'resignation_date' => $row['data_demissao'],
            'reason_dismissal' => $row['motivo_demissao'],
            'subsidiary_id' => $row['filial'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|min:1|max:191',
            'nome_social' => 'nullable|max:191',
            'genero' => 'nullable|in:Cisgênero,Feminino,Masculino,Não Binário,Outros,Transgênero',
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'cpf' => 'nullable|max:191',
            'rg' => 'nullable|max:191',
            'cnh' => 'nullable|max:191',
            'titulo_eleitor' => 'nullable|max:191',
            'email' => 'nullable|max:191',
            'telefone' => 'nullable|max:25',
            'celular' => 'nullable|max:25',
            'cep' => 'nullable|max:13',
            'rua' => 'nullable|max:100',
            'numero' => 'nullable|max:100',
            'complemento' => 'nullable|max:100',
            'bairro' => 'nullable|max:100',
            'uf' => 'nullable|max:3',
            'cidade' => 'nullable|max:100',
            'estado_civil' => 'nullable|in:Casado,Solteiro,União Estável,Viúvo',
            'conjuge' => 'nullable|max:191',
            'filhos' => 'nullable|integer|min:0',
            'bancp' => 'nullable|max:191',
            'agencia' => 'nullable|max:191',
            'conta' => 'nullable|max:191',
            'cargo' => 'nullable|max:191',
            'salario' => 'nullable|numeric|between:0,999999999.999',
            'data_admissao' => 'nullable|date_format:Y-m-d',
            'data_demissao' => 'nullable|date_format:Y-m-d',
            'motivo_demissao' => 'nullable|max:4000000000',
            'filial' => 'nullable|exists:subsidiaries,id',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $subsidiary = Subsidiary::where('alias_name', $data['filial'])->first();
        if ($subsidiary) {
            $data['filial'] = $data['filial'] ? $subsidiary->id : null;
        } else {
            $data['filial'] = null;
        }
        $data['salario'] = $data['salario'] ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $data['salario']))) : null;
        $data['data_nascimento'] = $data['data_nascimento'] ? Carbon::createFromFormat('d/m/Y', $data['data_nascimento'])->format('Y-m-d') : null;
        $data['data_admissao'] = $data['data_admissao'] ? Carbon::createFromFormat('d/m/Y', $data['data_admissao'])->format('Y-m-d') : null;
        $data['data_demissao'] = $data['data_demissao'] ? Carbon::createFromFormat('d/m/Y', $data['data_demissao'])->format('Y-m-d') : null;
        return $data;
    }
}
