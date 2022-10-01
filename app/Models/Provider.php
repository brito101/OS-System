<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'social_name', 'alias_name', 'document_company', 'document_company_secondary', 'activity', 'email', 'telephone', 'cell', 'contact', 'function', 'average_delivery_time', 'payment_conditions', 'discounts', 'products_offered', 'promotion_funds', 'technical_assistance', 'total_purchases_previous_year', 'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city', 'observations', 'coverage'
    ];
}
