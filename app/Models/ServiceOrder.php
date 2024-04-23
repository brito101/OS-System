<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

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
        'end_time',
        'remarks',
        'photo',
        'costumer_name',
        'costumer_document',
        'subsidiary_id',
        'type',
    ];


    /** Relationships */
    public function activity()
    {
        return $this->belongsTo(Activity::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }

    public function photos()
    {
        return $this->hasMany(ServiceOrderPhoto::class);
    }

    public function files()
    {
        return $this->hasMany(ServiceOrderFile::class);
    }

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
}
