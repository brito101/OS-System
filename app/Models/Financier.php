<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Financier extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'subsidiary_id'];

    /** Relationships */
    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }
}
