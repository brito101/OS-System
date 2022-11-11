<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['nome'],
            'description' => $row['descricao'],
            'unity' => $row['unidade_consumo'],
            'min_stock' => $row['estoque_minimo'],
            'max_stock' => $row['estoque_maximo'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|min:1|max:191',
            'descricao' => 'nullable|max:191',
            'unidade_consumo' => 'nullable|max:191',
            'estoque_minimo' => 'nullable|integer|min:-999999999|max:999999999',
            'estoque_maximo' => 'nullable|integer|min:-999999999|max:999999999'
        ];
    }
}
