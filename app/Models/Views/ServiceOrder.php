<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'service_orders_view';

    /** Accessor */
    public function getDeadlineAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
