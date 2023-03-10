<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetCommittee extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['value'];

    protected $appends = ['value_pt'];

    /** Accessor */
    public function getValuePtAttribute()
    {
        return \number_format($this->value, 2, ',', '.');
    }
}
