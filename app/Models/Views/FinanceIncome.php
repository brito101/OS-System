<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinanceIncome extends Model
{
    use HasFactory;

    protected $table = 'finance_incomes_view';

    protected $appends = [
        'author',
        'subsidiary'
    ];

    /** Access */
    public function getDescriptionAttribute($value)
    {
        return Str::limit($value, 15);
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
        return Str::words(User::find($this->user_id)->name, 3);
    }

    public function getSubsidiaryAttribute($value)
    {
        return Str::words(Subsidiary::find($this->subsidiary_id)->alias_name, 3);
    }
}
