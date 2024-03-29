<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'date', 'subsidiary_id', 'job', 'provider_id', 'number_series', 'invoice', 'amount', 'value', 'requester', 'forecast', 'authorized', 'authorized_date', 'freight', 'purchase_mode', 'status', 'file'];

    protected $appends = [
        'author',
        'subsidiary',
        'amount'
    ];

    /** Accessor */
    public function getDateAttribute($value)
    {
        if ($value) {
            return date("d/m/Y", strtotime($value));
        } else {
            return null;
        }
    }

    public function getForecastAttribute($value)
    {
        if ($value) {
            return date("d/m/Y", strtotime($value));
        } else {
            return null;
        }
    }

    public function getAuthorizedDateAttribute($value)
    {
        if ($value) {
            return date("d/m/Y", strtotime($value));
        } else {
            return null;
        }
    }

    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
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
