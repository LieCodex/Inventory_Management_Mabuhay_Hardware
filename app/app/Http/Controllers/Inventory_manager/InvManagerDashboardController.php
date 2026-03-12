<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\SupplierInfo;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InvManagerDashboardController extends Controller
{
        public function index()
    {
        // 1. Sales Overview
        $salesCount = Transaction::count(); 
        $revenue = Transaction::sum('total_amount') ?? 0; 
        
        // Calculate true cost by joining transaction items with their original inventory batches
        $cost = DB::table('transaction_items')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->sum(DB::raw('transaction_items.quantity * inventory_batches.price'));

        $profit = $revenue - $cost; 

        // 2. Inventory Summary
        $quantityInHand = Item::sum('quantity_on_hand');
        $toBeReceived = SupplierInfo::sum('quantity_on_the_way');

        // 3. Item Summary
        $supplierCount = SupplierInfo::count();
        $categoryCount = Item::whereNotNull('category')->distinct('category')->count('category');

        // 4. Low Quantity Stock
        $lowStockItems = Item::whereColumn('quantity_on_hand', '<=', 'low_stock_threshold')
            ->orderBy('quantity_on_hand', 'asc')
            ->take(4)
            ->get();

        // 5. Top Selling Stock
        $topSelling = TransactionItem::with('item')
            ->select('item_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_id')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        return view('inventory_manager.dashboard', compact(
            'salesCount', 'revenue', 'cost', 'profit',
            'quantityInHand', 'toBeReceived',
            'supplierCount', 'categoryCount',
            'lowStockItems', 'topSelling'
        ));
    }
}