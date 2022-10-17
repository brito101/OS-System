<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinanceExpense extends Model
{
    use HasFactory;

    protected $table = 'finance_expenses_view';

    protected $appends = [
        'author',
        'subsidiary'
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

    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /** Aux */
    public function getAuthorAttribute($value)
    {
        return User::find($this->user_id)->name;
    }

    public function getSubsidiaryAttribute($value)
    {
        return Subsidiary::find($this->subsidiary_id)->alias_name;
    }
}