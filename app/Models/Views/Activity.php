<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities_view';

    /** Accessor */
    public function getDurationAttribute($value)
    {
        return \str_replace(':', 'h', date('H:i', strtotime($value))) . 'min';
    }
}
