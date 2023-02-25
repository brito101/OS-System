<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'service_orders_view';

    protected $appends = [
        'deadline_pt',
        'readiness_date_pt'
    ];


    /** Accessor */
    public function getDeadlinePtAttribute($value)
    {
        return date("d/m/Y", strtotime($this->deadline));
    }

    public function getReadinessDatePtAttribute($value)
    {
        return $value ? date("d/m/Y", strtotime($value)) : '';
    }
}
