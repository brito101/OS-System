<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'client_id',
        'action',
        'trade_status',
        'user_id',
        'subsidiary_id'
    ];

    /** Relationships */
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

    /** Accessors */
    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i", strtotime($value));
    }
}
