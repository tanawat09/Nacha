<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeanSproutSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\BeanSproutSale::orderBy('production_date', 'desc')->orderBy('created_at', 'desc');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('production_date', [$request->start_date, $request->end_date]);
        }

        $sales = $query->paginate(20);
        $totalProfit = $query->clone()->sum('profit');
        $totalRevenue = $query->clone()->sum('total_revenue');

        return view('bean-sprout-sales.index', compact('sales', 'totalProfit', 'totalRevenue'));
    }

    public function create()
    {
        $products = \App\Models\Product::where('category', 'sprout')->get();
        return view('bean-sprout-sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'production_date' => 'required|date',
            'quantity_produced_kg' => 'required|numeric|min:0',
            'cost_per_kg' => 'required|numeric|min:0',
            'selling_price_per_kg' => 'required|numeric|min:0',
            'quantity_sold_kg' => 'required|numeric|min:0',
        ]);

        $validated['total_cost'] = $validated['quantity_produced_kg'] * $validated['cost_per_kg'];
        $validated['total_revenue'] = $validated['quantity_sold_kg'] * $validated['selling_price_per_kg'];
        $validated['profit'] = $validated['total_revenue'] - $validated['total_cost'];

        \App\Models\BeanSproutSale::create($validated);

        return redirect()->route('bean-sprout-sales.index')->with('success', 'บันทึกรายการสำเร็จ');
    }

    public function show(\App\Models\BeanSproutSale $beanSproutSale)
    {
        return view('bean-sprout-sales.show', compact('beanSproutSale'));
    }

    public function edit(\App\Models\BeanSproutSale $beanSproutSale)
    {
        return view('bean-sprout-sales.edit', compact('beanSproutSale'));
    }

    public function update(Request $request, \App\Models\BeanSproutSale $beanSproutSale)
    {
        $validated = $request->validate([
            'production_date' => 'required|date',
            'quantity_produced_kg' => 'required|numeric|min:0',
            'cost_per_kg' => 'required|numeric|min:0',
            'selling_price_per_kg' => 'required|numeric|min:0',
            'quantity_sold_kg' => 'required|numeric|min:0',
        ]);

        $validated['total_cost'] = $validated['quantity_produced_kg'] * $validated['cost_per_kg'];
        $validated['total_revenue'] = $validated['quantity_sold_kg'] * $validated['selling_price_per_kg'];
        $validated['profit'] = $validated['total_revenue'] - $validated['total_cost'];

        $beanSproutSale->update($validated);

        return redirect()->route('bean-sprout-sales.index')->with('success', 'อัปเดตรายการสำเร็จ');
    }

    public function destroy(\App\Models\BeanSproutSale $beanSproutSale)
    {
        $beanSproutSale->delete();
        return redirect()->route('bean-sprout-sales.index')->with('success', 'ลบรายการสำเร็จ');
    }
}
