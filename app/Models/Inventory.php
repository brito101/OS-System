<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['product_id', 'day', 'value', 'validity', 'input', 'output', 'user_id', 'observations', 'subsidiary_id'];

    protected $appends = [
        'product',
        'subsidiary',
        'input_value',
        'output_value',
        'balance',
    ];

    /** Accessors */
    public function getDayAttribute($value)
    {
        if ($value) {
            return date("d/m/Y", strtotime($value));
        } else {
            return 'Indeterminado';
        }
    }

    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getValidityAttribute($value)
    {
        if ($value) {
            return date("d/m/Y", strtotime($value));
        } else {
            return 'Indeterminado';
        }
    }

    public function getSubsidiaryAttribute($value)
    {
        $subsidiary = Subsidiary::find($this->subsidiary_id);
        if ($subsidiary) {
            return $subsidiary->alias_name;
        } else {
            return '-';
        }
    }

    public function getProductAttribute($value)
    {
        $product = Product::find($this->product_id);
        if ($product) {
            return $product->name;
        } else {
            return 'Inexistente';
        }
    }

    public function getInputValueAttribute($value)
    {
        $product = Product::find($this->product_id);
        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))) * $this->input;
        return $this->input . " ($product->unity) :: " . 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getOutputValueAttribute($value)
    {
        $product = Product::find($this->product_id);
        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))) * $this->output;
        return $this->output . " ($product->unity) :: " . 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getBalanceAttribute($value)
    {
        $product = Product::find($this->product_id);
        $total = $this->input - $this->output;
        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))) * $total;
        return $total . " ($product->unity) :: " . 'R$ ' . \number_format($value, 2, ',', '.');
    }
}
