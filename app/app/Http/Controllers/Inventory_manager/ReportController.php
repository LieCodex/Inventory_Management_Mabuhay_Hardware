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
        $netPurchaseValue = InventoryBatch::sum(DB::raw('quantity_remaining * price')) ?? 0; // What you paid for current stock
        $netSalesValue = Item::sum(DB::raw('quantity_on_hand * price_per_unit')) ?? 0; // What you will sell it for

        // 3. Month-over-Month (MoM) & Year-over-Year (YoY) Profit
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $momRevenue = Transaction::whereMonth('transaction_date', $currentMonth)->whereYear('transaction_date', $currentYear)->sum('total_amount') ?? 0;
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

        // 4. Best Selling Categories
        $bestCategories = DB::table('transaction_items')
            ->join('items', 'transaction_items.item_id', '=', 'items.id')
            ->select('items.category', DB::raw('SUM(transaction_items.subtotal) as turnover'))
            ->whereNotNull('items.category')
            ->groupBy('items.category')
            ->orderByDesc('turnover')
            ->take(4)
            ->get();

        // 5. Best Selling Products
        $bestProducts = TransactionItem::with('item')
            ->select('item_id', DB::raw('SUM(subtotal) as turnover'))
            ->groupBy('item_id')
            ->orderByDesc('turnover')
            ->take(4)
            ->get();

        return view('inventory_manager.reports', compact(
            'revenue', 'cost', 'profit', 
            'netPurchaseValue', 'netSalesValue', 
            'momProfit', 'yoyProfit', 
            'bestCategories', 'bestProducts'
        ));
    }
}