<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kanban extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description',
        'value',
        'status',
        'user_id'
    ];

    /** Accessor */
    public function getValueAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }
}
