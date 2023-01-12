<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'finance_purchase_orders_view';

    protected $appends = [
        'author',
        'subsidiary',
        'amount',
        'date_pt',
        'forecast_pt'
    ];

    /** Accessor */
    public function getDatePtAttribute($value)
    {
        return date("d/m/Y", strtotime($this->date));
    }

    public function getForecastPtAttribute($value)
    {
        return date("d/m/Y", strtotime($this->forecast));
    }

    public function getAuthorizedDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }

    public function getAmountAttribute($value)
    {
        return (float) str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value)));
    }

    /** relationships */
    public function purchaseOrder()
    {
        return $this->hsMany(Material::class);
    }

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'purchase_orders_id');
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
