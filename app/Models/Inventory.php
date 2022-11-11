<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['product_id', 'day', 'value', 'validity', 'input', 'output', 'user_id'];

    protected $appends = [
        'product',
        'input_value',
        'output_value',
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
        return;
    }
}
