<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('water_sales', function (Blueprint $table) {
            $table->id();
            $table->date('sale_date');
            $table->string('product_type');
            $table->decimal('cost_per_unit', 10, 2);
            $table->decimal('selling_price_per_unit', 10, 2);
            $table->integer('quantity_sold')->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_sales');
    }
};
