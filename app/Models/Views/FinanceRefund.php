<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinanceRefund extends Model
{
    use HasFactory;

    protected $table = 'finance_refunds_view';

    protected $appends = [
        'author',
        'subsidiary',
        'amount'

    ];

    /** Access */
    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getAmountAttribute($value)
    {
        return (float) str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value)));
    }

    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /** Aux */
    public function getAuthorAttribute($value)
    {
        return User::find($this->user_id)->name ?? 'Inexistente';
    }

    public function getSubsidiaryAttribute($value)
    {
        return Subsidiary::find($this->subsidiary_id)->alias_name ?? 'Inexistente';
    }
}
