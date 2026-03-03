<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        // Daily summaries
        $dailyIncome = \App\Models\Transaction::whereDate('transaction_date', $today)->where('type', 'income')->sum('amount');
        $dailyExpense = \App\Models\Transaction::whereDate('transaction_date', $today)->where('type', 'expense')->sum('amount');
        $dailySproutProfit = \App\Models\BeanSproutSale::whereDate('production_date', $today)->sum('profit');
        $dailyWaterProfit = \App\Models\WaterSale::whereDate('sale_date', $today)->sum('profit');

        // Monthly summaries
        $monthlyIncome = \App\Models\Transaction::whereMonth('transaction_date', $currentMonth)->whereYear('transaction_date', $currentYear)->where('type', 'income')->sum('amount');
        $monthlyExpense = \App\Models\Transaction::whereMonth('transaction_date', $currentMonth)->whereYear('transaction_date', $currentYear)->where('type', 'expense')->sum('amount');
        $monthlySproutProfit = \App\Models\BeanSproutSale::whereMonth('production_date', $currentMonth)->whereYear('production_date', $currentYear)->sum('profit');
        $monthlyWaterProfit = \App\Models\WaterSale::whereMonth('sale_date', $currentMonth)->whereYear('sale_date', $currentYear)->sum('profit');

        // Chart Data (Last 7 days income/expense)
        $chartDates = [];
        $chartIncome = [];
        $chartExpense = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartDates[] = $date;
            
            // Daily pure transaction income
            $transIncome = \App\Models\Transaction::whereDate('transaction_date', $date)->where('type', 'income')->sum('amount');
            
            // Daily pure transaction expense
            $transExpense = \App\Models\Transaction::whereDate('transaction_date', $date)->where('type', 'expense')->sum('amount');
            
            // Daily sales profits
            $sproutProfit = \App\Models\BeanSproutSale::whereDate('production_date', $date)->sum('profit');
            $waterProfit = \App\Models\WaterSale::whereDate('sale_date', $date)->sum('profit');

            // Total Income = Transaction Income + Sprout Profit + Water Profit
            // Alternatively, user might just want standard transactions. We will add them all together for a holistic view.
            $dailyIncomeTotal = $transIncome + max(0, $sproutProfit) + max(0, $waterProfit);
            
            // If profit is negative, it's a loss (expense)
            $dailyExpenseTotal = $transExpense + abs(min(0, $sproutProfit)) + abs(min(0, $waterProfit));

            $chartIncome[] = $dailyIncomeTotal;
            $chartExpense[] = $dailyExpenseTotal;
        }

        return view('dashboard', compact(
            'dailyIncome', 'dailyExpense', 'dailySproutProfit', 'dailyWaterProfit',
            'monthlyIncome', 'monthlyExpense', 'monthlySproutProfit', 'monthlyWaterProfit',
            'chartDates', 'chartIncome', 'chartExpense'
        ));
    }
}
