<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\WaterSale::orderBy('sale_date', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
        }

        $sales = $query->paginate(20);
        $totalProfit = $query->clone()->sum('profit');
        $totalRevenue = $query->clone()->sum('total_revenue');

        return view('water-sales.index', compact('sales', 'totalProfit', 'totalRevenue'));
    }

    public function create()
    {
        $products = \App\Models\Product::where('category', 'water')->get();
        return view('water-sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'product_type' => 'required|string|max:255',
            'cost_per_unit' => 'required|numeric|min:0',
            'selling_price_per_unit' => 'required|numeric|min:0',
            'quantity_sold' => 'required|integer|min:0',
        ]);

        $validated['total_cost'] = $validated['quantity_sold'] * $validated['cost_per_unit'];
        $validated['total_revenue'] = $validated['quantity_sold'] * $validated['selling_price_per_unit'];
        $validated['profit'] = $validated['total_revenue'] - $validated['total_cost'];

        \App\Models\WaterSale::create($validated);

        // Deduct Stock
        $this->deductStock($validated['product_type'], $validated['quantity_sold']);

        return redirect()->route('water-sales.index')->with('success', 'บันทึกรายการสำเร็จ และตัดสต๊อกเรียบร้อยแล้ว');
    }

    private function deductStock($productName, $quantitySold)
    {
        $product = \App\Models\Product::where('name', $productName)->first();
        if ($product) {
            $product->stock = max(0, $product->stock - $quantitySold);
            $product->save();
        }
    }

    public function show(\App\Models\WaterSale $waterSale)
    {
        return view('water-sales.show', compact('waterSale'));
    }

    public function edit(\App\Models\WaterSale $waterSale)
    {
        return view('water-sales.edit', compact('waterSale'));
    }

    public function update(Request $request, \App\Models\WaterSale $waterSale)
    {
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'product_type' => 'required|string|max:255',
            'cost_per_unit' => 'required|numeric|min:0',
            'selling_price_per_unit' => 'required|numeric|min:0',
            'quantity_sold' => 'required|integer|min:0',
        ]);

        $validated['total_cost'] = $validated['quantity_sold'] * $validated['cost_per_unit'];
        $validated['total_revenue'] = $validated['quantity_sold'] * $validated['selling_price_per_unit'];
        $validated['profit'] = $validated['total_revenue'] - $validated['total_cost'];

        $waterSale->update($validated);

        return redirect()->route('water-sales.index')->with('success', 'อัปเดตรายการสำเร็จ');
    }

    public function destroy(\App\Models\WaterSale $waterSale)
    {
        $waterSale->delete();
        return redirect()->route('water-sales.index')->with('success', 'ลบรายการสำเร็จ');
    }
}
