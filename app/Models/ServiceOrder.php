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

    /** Accessor */
    public function getExecutionDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getDeadlineAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    /** Relationships */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
