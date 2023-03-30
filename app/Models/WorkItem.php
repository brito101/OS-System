<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code', 'description', 'unity', 'category', 'value', 'tax', 'commercial', 'fee',
    ];

    protected $appends = [
        'value_pt', 'tax_pt', 'commercial_pt', 'fee_pt',
    ];

    /** Accessors */
    public function getValuePtAttribute()
    {
        return 'R$ ' . \number_format($this->value, 2, ',', '.');
    }

    public function getTaxPtAttribute()
    {
        return \number_format($this->tax, 2, ',', '.') . ' %';
    }

    public function getCommercialPtAttribute()
    {
        return \number_format($this->commercial, 2, ',', '.');
    }

    public function getFeePtAttribute()
    {
        return \number_format($this->fee, 2, ',', '.');
    }
}
