<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        $products = \App\Models\Product::orderBy('category')->orderBy('id')->get();
        return view('settings.index', compact('settings', 'products'));
    }

    public function store(Request $request)
    {
        // 1. Setup Static Settings
        $settingData = $request->except(['_token', 'products']);
        foreach ($settingData as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // 2. Setup Dynamic Products (Insert or Update)
        $submittedIds = [];
        if ($request->has('products')) {
            foreach ($request->products as $prodData) {
                if (empty($prodData['name'])) continue; // Skip empty rows
                
                $product = null;
                if (!empty($prodData['id'])) {
                    $product = \App\Models\Product::find($prodData['id']);
                }
                
                if (!$product) {
                    $product = new \App\Models\Product();
                }

                $product->category = $prodData['category'] ?? 'other';
                $product->name = $prodData['name'];
                $product->cost_per_unit = $prodData['cost_per_unit'] ?? 0;
                $product->selling_price_per_unit = $prodData['selling_price_per_unit'] ?? 0;
                $product->stock = $prodData['stock'] ?? 0;
                $product->save();

                $submittedIds[] = $product->id;
            }
        }

        // 3. Delete Products that were removed from the UI
        \App\Models\Product::whereNotIn('id', $submittedIds)->delete();

        return redirect()->route('settings.index')->with('success', 'บันทึกการตั้งค่าและรายการสินค้าเรียบร้อยแล้ว!');
    }
}
