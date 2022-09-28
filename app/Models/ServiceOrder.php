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
        'observations',
        'costumer_signature',
        'contributor_signature',
        'author',
        'readiness_date',
        'number_series',
        'start_time',
        'end_time'
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

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }

    public function getAuthorAttribute($value)
    {
        $user = User::find($value);
        return $user;
    }

    public function getReadinessDateAttribute($value)
    {
        return $value ? date("d/m/Y", strtotime($value)) : null;
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? date("H:i", strtotime($value)) : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? date("H:i", strtotime($value)) : null;
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
