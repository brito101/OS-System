<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'alias_name', 'genre', 'birth_date', 'photo', 'document_primary',
        'document_secondary', 'driver_license', 'voter_registration', 'email', 'telephone', 'cell',
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city', 'marital_status',
        'spouse', 'sons', 'bank', 'agency', 'account', 'role', 'salary', 'admission_date', 'resignation_date',
        'reason_dismissal', 'subsidiary_id', 'user_id', 'pix'
    ];

    /** Relationships */
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault(
            ['alias_name' => 'Sem Filial',]
        );
    }
}
