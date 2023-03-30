<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstructionBudget extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'item_1_qtd',
        'item_2_qtd',
        'item_3_qtd',
        'item_4_qtd',
        'item_5_qtd',
        'item_6_qtd',
        'item_7_qtd',
        'item_8_qtd',
        'item_9_qtd',
        'item_10_qtd',
        'item_11_qtd',
        'item_12_qtd',
        'item_13_qtd',
        'item_14_qtd',
        'item_15_qtd',
        'item_16_qtd',
        'item_17_qtd',
        'item_18_qtd',
        'item_19_qtd',
        'item_20_qtd',
        'item_21_qtd',
        'item_22_qtd',
        'item_23_qtd',
        'item_24_qtd',
        'item_25_qtd',
        'item_26_qtd',
        'item_27_qtd',
        'item_28_qtd',
        'item_29_qtd',
        'item_30_qtd',
        'item_31_qtd',
        'item_32_qtd',
        'item_33_qtd',
        'item_1_total_tax',
        'item_2_total_tax',
        'item_3_total_tax',
        'item_4_total_tax',
        'item_5_total_tax',
        'item_6_total_tax',
        'item_7_total_tax',
        'item_8_total_tax',
        'item_9_total_tax',
        'item_10_total_tax',
        'item_11_total_tax',
        'item_12_total_tax',
        'item_13_total_tax',
        'item_14_total_tax',
        'item_15_total_tax',
        'item_16_total_tax',
        'item_17_total_tax',
        'item_18_total_tax',
        'item_19_total_tax',
        'item_20_total_tax',
        'item_21_total_tax',
        'item_22_total_tax',
        'item_23_total_tax',
        'item_24_total_tax',
        'item_25_total_tax',
        'item_26_total_tax',
        'item_27_total_tax',
        'item_28_total_tax',
        'item_29_total_tax',
        'item_30_total_tax',
        'item_31_total_tax',
        'item_32_total_tax',
        'item_33_total_tax',
        'user_id'
    ];
}
