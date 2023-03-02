<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees_view';

    /** Accessors */
    public function getSalaryAttribute($value)
    {
        return 'R$ ' . \number_format($value, 2, ',', '.');
    }
}
