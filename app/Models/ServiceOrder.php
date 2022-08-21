<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'telephone',
        'client_id',
        'description',
        'user_id',
        'execution_date',
        'priority',
        'status',
        'deadline',
        'appraisal',
        'observations'
    ];
}
