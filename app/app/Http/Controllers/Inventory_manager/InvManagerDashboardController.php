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
        // Return View with all variables
        return view('inventory_manager.dashboard', [
            'salesCount' => Transaction::count(),
            'revenue' => Transaction::sum('total_amount') ?? 0,
            'cost' => DB::table('transaction_items')
                ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
                ->sum(DB::raw('transaction_items.quantity * inventory_batches.price')),
            'profit' => (Transaction::sum('total_amount') ?? 0) - (DB::table('transaction_items')->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')->sum(DB::raw('transaction_items.quantity * inventory_batches.price'))),
            'quantityInHand' => Item::sum('quantity_on_hand'),
            'toBeReceived' => SupplierInfo::sum('quantity_on_the_way'),
            'supplierCount' => SupplierInfo::count(),
            'categoryCount' => Item::whereNotNull('category')->distinct('category')->count('category'),
            'lowStockItems' => Item::whereColumn('quantity_on_hand', '<=', 'low_stock_threshold')->take(4)->get(),
            'topSelling' => TransactionItem::with('item')->select('item_id', DB::raw('SUM(quantity) as total_sold'))->groupBy('item_id')->orderByDesc('total_sold')->take(4)->get(),
        ]);
    }
}