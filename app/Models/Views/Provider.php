<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers_view';

    /** Accessor */
    public function getCoverageAttribute($value)
    {
        return implode(", ", explode(",", $value));
    }
}
