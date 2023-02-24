<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'document_person', 'document_registry',
        'email', 'telephone', 'cell', 'zipcode', 'street', 'number', 'complement',
        'neighborhood', 'state', 'city', 'company', 'observations', 'service', 'trade_status', 'type', 'origin', 'apartments', 'contact', 'subsidiary_id', 'seller_id', 'contact_function', 'value_per_apartment', 'total_value', 'meeting', 'status_sale', 'reason_refusal',
    ];

    /** Relationships */
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function files()
    {
        return $this->hasMany(ClientFile::class);
    }

    /** Accessors */
    public function getValuePerApartmentAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    public function getTotalValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }

    /** Aux */
    public function getAddress()
    {
        return ($this->street ? $this->street . ', ' : '') . ($this->number ? 'nº ' . $this->number . '. ' : '') . ($this->neighborhood ? 'Bairro: ' . $this->neighborhood : '') . '. ' . $this->city . '-' . $this->state . '. CEP: ' . $this->zipcode . '. ' . ($this->complement ?? $this->complement);
    }
}
