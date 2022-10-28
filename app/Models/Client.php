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
        'neighborhood', 'state', 'city', 'company', 'observations', 'service', 'trade_status', 'type', 'origin', 'apartments', 'contact', 'subsidiary_id', 'seller'
    ];

    /** Relationships */
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class);
    }
}
