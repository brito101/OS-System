<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['employee', 'due_date', 'total_value', 'status', 'observations', 'subsidiary_id', 'user_id'];

    protected $appends = [
        'author',
        'subsidiary',
        'amount',
        'due_date_pt'
    ];

    /** Accessors */
    public function getTotalValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getAmountAttribute($value)
    {
        return (float) str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value)));
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }

    public function getDueDatePtAttribute($value)
    {
        return date("d/m/Y", strtotime($this->due_date));
    }

    /** Aux */
    public function getAuthorAttribute($value)
    {
        return User::find($this->user_id)->name ?? 'Inexistente';
    }

    public function getSubsidiaryAttribute($value)
    {
        return Subsidiary::find($this->subsidiary_id)->alias_name ?? 'Sem Filial';
    }
}
