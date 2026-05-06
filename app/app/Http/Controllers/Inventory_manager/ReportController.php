<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Item;
use App\Models\InventoryBatch;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Overall Profit, Revenue & Cost
        $revenue = Transaction::sum('total_amount') ?? 0;
        
        $cost = DB::table('transaction_items')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->sum(DB::raw('transaction_items.quantity * inventory_batches.price')) ?? 0;
            
        $profit = $revenue - $cost;

        // 2. Net Values (Value of current warehouse stock)
        $netPurchaseValue = InventoryBatch::sum(DB::raw('quantity_remaining * price')) ?? 0;
        $netSalesValue = Item::sum(DB::raw('quantity_on_hand * price_per_unit')) ?? 0;

        // 3. Month-over-Month (MoM) & Year-over-Year (YoY)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $momRevenue = Transaction::whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)->sum('total_amount') ?? 0;
            
        $momCost = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->whereMonth('transactions.transaction_date', $currentMonth)
            ->whereYear('transactions.transaction_date', $currentYear)
            ->sum(DB::raw('transaction_items.quantity * inventory_batches.price')) ?? 0;
            
        $momProfit = $momRevenue - $momCost;

        $yoyRevenue = Transaction::whereYear('transaction_date', $currentYear)->sum('total_amount') ?? 0;
        $yoyCost = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->whereYear('transactions.transaction_date', $currentYear)
            ->sum(DB::raw('transaction_items.quantity * inventory_batches.price')) ?? 0;
            
        $yoyProfit = $yoyRevenue - $yoyCost;

        // 4. Best Selling Categories with Trends
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousMonthYear = Carbon::now()->subMonth()->year;

        $bestCategories = DB::table('transaction_items')
            ->join('items', 'transaction_items.item_id', '=', 'items.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->select(
                'items.category',
                DB::raw('SUM(transaction_items.subtotal) as total_turnover'),
                DB::raw('SUM(CASE WHEN MONTH(transactions.transaction_date) = ' . $currentMonth . ' AND YEAR(transactions.transaction_date) = ' . $currentYear . ' THEN transaction_items.subtotal ELSE 0 END) as current_turnover'),
                DB::raw('SUM(CASE WHEN MONTH(transactions.transaction_date) = ' . $previousMonth . ' AND YEAR(transactions.transaction_date) = ' . $previousMonthYear . ' THEN transaction_items.subtotal ELSE 0 END) as previous_turnover')
            )
            ->whereNotNull('items.category')
            ->groupBy('items.category')
            ->having('total_turnover', '>', 0)
            ->orderByDesc('total_turnover')
            ->take(4)
            ->get()
            ->map(function ($category) {
                $current = $category->current_turnover;
                $previous = $category->previous_turnover;

                if ($current > 0 && $previous > 0) {
                    $trend = (($current - $previous) / $previous) * 100;
                    $category->trend_percentage = round($trend, 1);
                    $category->trend_direction = $trend > 0 ? 'up' : ($trend < 0 ? 'down' : 'flat');
                } elseif ($current > 0 && $previous === 0) {
                    $category->trend_percentage = null;
                    $category->trend_direction = 'new';
                } elseif ($current === 0 && $previous > 0) {
                    $category->trend_percentage = 100;
                    $category->trend_direction = 'down';
                } else {
                    $category->trend_percentage = null;
                    $category->trend_direction = 'flat';
                }

                $category->turnover = $category->total_turnover;
                return $category;
            });

        // 5. Best Selling Products
        $bestProducts = TransactionItem::with('item')
            ->select('item_id', DB::raw('SUM(subtotal) as turnover'))
            ->groupBy('item_id')
            ->orderByDesc('turnover')
            ->take(4)
            ->get();

        // 6. Chart Data for Profit & Revenue
        $monthlyRevenue = Transaction::whereYear('transaction_date', $currentYear)
            ->selectRaw('MONTH(transaction_date) as month_num, DATE_FORMAT(transaction_date, "%b") as month, SUM(total_amount) as revenue')
            ->groupBy('month_num', 'month')
            ->orderBy('month_num')
            ->get()
            ->keyBy('month_num');

        $monthlyCost = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->whereYear('transactions.transaction_date', $currentYear)
            ->selectRaw('MONTH(transactions.transaction_date) as month_num, SUM(transaction_items.quantity * inventory_batches.price) as cost')
            ->groupBy('month_num')
            ->get()
            ->keyBy('month_num');

        $chartLabels = [];
        $chartRevenue = [];
        $chartProfit = [];

        // Combine the data
        foreach ($monthlyRevenue as $monthNum => $data) {
            $chartLabels[] = $data->month;
            
            $rev = $data->revenue;
            $costVal = isset($monthlyCost[$monthNum]) ? $monthlyCost[$monthNum]->cost : 0;
            
            $chartRevenue[] = $rev;
            $chartProfit[] = $rev - $costVal;
        }

        return view('inventory_manager.reports', compact(
            'revenue', 'cost', 'profit', 
            'netPurchaseValue', 'netSalesValue', 
            'momProfit', 'yoyProfit', 
            'bestCategories', 'bestProducts',
            'chartLabels', 'chartRevenue', 'chartProfit' // <-- Added chartProfit here
        ));
    }
}