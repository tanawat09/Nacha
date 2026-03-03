<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Transaction::orderBy('transaction_date', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->paginate(20);

        $totalIncome = $query->clone()->where('type', 'income')->sum('amount');
        $totalExpense = $query->clone()->where('type', 'expense')->sum('amount');
        $profit = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'profit'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        \App\Models\Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'บันทึกรายการสำเร็จ');
    }

    public function show(\App\Models\Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function edit(\App\Models\Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, \App\Models\Transaction $transaction)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'อัปเดตรายการสำเร็จ');
    }

    public function destroy(\App\Models\Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'ลบรายการสำเร็จ');
    }
}
