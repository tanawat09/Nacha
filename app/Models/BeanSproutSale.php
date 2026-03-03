<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeanSproutSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_date',
        'quantity_produced_kg',
        'cost_per_kg',
        'selling_price_per_kg',
        'quantity_sold_kg',
        'total_cost',
        'total_revenue',
        'profit',
    ];
}
