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
        'subsidiary'
    ];

    /** Accessor */
    public function getDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getForecastAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
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

    /** relationships */
    public function purchaseOrder()
    {
        return $this->hsMany(Material::class);
    }

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'purchase_orders_id');
    }

    /** Aux */
    public function getAuthorAttribute($value)
    {
        return Str::words(User::find($this->user_id)->name, 5);
    }

    public function getSubsidiaryAttribute($value)
    {
        return Str::words(Subsidiary::find($this->subsidiary_id)->alias_name, 5);
    }
}
