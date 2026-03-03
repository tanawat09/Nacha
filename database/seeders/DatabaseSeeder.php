<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Transaction::create([
            'type' => 'income',
            'category' => 'เงินทุนเริ่มต้น',
            'amount' => 50000.00,
            'transaction_date' => now()->subDays(10)->format('Y-m-d'),
            'note' => 'ทดสอบระบบ',
        ]);

        \App\Models\Transaction::create([
            'type' => 'expense',
            'category' => 'ซื้อเมล็ดถั่วเขียว',
            'amount' => 1500.00,
            'transaction_date' => now()->subDays(5)->format('Y-m-d'),
            'note' => '',
        ]);

        \App\Models\BeanSproutSale::create([
            'production_date' => now()->subDays(2)->format('Y-m-d'),
            'quantity_produced_kg' => 100,
            'cost_per_kg' => 10.50,
            'selling_price_per_kg' => 25.00,
            'quantity_sold_kg' => 85.5,
            'total_cost' => 1050.00, // 100 * 10.50
            'total_revenue' => 2137.50, // 85.5 * 25
            'profit' => 1087.50, // 2137.50 - 1050.00
        ]);

        \App\Models\WaterSale::create([
            'sale_date' => now()->subDays(1)->format('Y-m-d'),
            'product_type' => 'ขวดใหญ่',
            'cost_per_unit' => 6.00,
            'selling_price_per_unit' => 15.00,
            'quantity_sold' => 120,
            'total_cost' => 720.00, // 120 * 6.00
            'total_revenue' => 1800.00, // 120 * 15.00
            'profit' => 1080.00, // 1800 - 720
        ]);    
    }
}
