<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsidiary extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'social_name', 'alias_name', 'document_company', 'document_company_secondary',
        'email', 'telephone', 'cell', 'zipcode', 'street', 'number', 'complement',
        'neighborhood', 'state', 'city'
    ];

    /** Relationships */
    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function financiers()
    {
        return $this->hasMany(Financier::class);
    }
}
