<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kanban extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'client_id',
        'description',
        'proposal',
        'status',
        'user_id'
    ];

    /** Relationships */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /** Accessor */
    public function getProposalAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }
}
