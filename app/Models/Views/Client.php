<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients_view';

    /** Accessors */
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }
}
