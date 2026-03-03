<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_date',
        'product_type',
        'cost_per_unit',
        'selling_price_per_unit',
        'quantity_sold',
        'total_cost',
        'total_revenue',
        'profit',
    ];
}
