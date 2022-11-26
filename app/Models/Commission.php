<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['seller_id', 'product', 'job', 'job_value', 'percentage', 'total_value', 'due_date', 'status', 'subsidiary_id', 'user_id'];


    protected $appends = [
        'seller',
        'author',
        'subsidiary',
        'amount',
    ];

    /** Accessors */
    public function getJobValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getPercentageAttribute($value)
    {
        return \number_format($value, 2, ',', '.') . " %";
    }

    public function getTotalValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getAmountAttribute($value)
    {
        return (float) str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value)));
    }

    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }

    /** Aux */
    public function getSellerAttribute($value)
    {
        return Seller::find($this->seller_id)->name;
    }

    public function getAuthorAttribute($value)
    {
        return User::find($this->user_id)->name;
    }

    public function getSubsidiaryAttribute($value)
    {
        return Subsidiary::find($this->subsidiary_id)->alias_name;
    }
}
