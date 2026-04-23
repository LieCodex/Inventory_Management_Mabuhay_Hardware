<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\InventoryBatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
        {
            // Get paginated items with their expiry dates
            $items = Item::with(['inventoryBatches' => function ($query) {
                $query->orderBy('expiry_date', 'asc');
            }])->paginate(10);
            
            // 1. Category Count
            $categoryCount = Item::whereNotNull('category')->distinct('category')->count('category');

            // 2. Total Items & 7-Day Revenue
            $totalProducts = Item::sum('quantity_on_hand');
            $revenue7Days = DB::table('transactions')
                ->where('created_at', '>=', now()->subDays(7))
                ->sum('total_amount') ?? 0;

            // 3. Items Sold & 7-Day Cost
            $topSelling = DB::table('transaction_items')
                ->where('created_at', '>=', now()->subDays(7))
                ->sum('quantity') ?? 0;
                
            $cost7Days = DB::table('transaction_items')
                ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
                ->where('transaction_items.created_at', '>=', now()->subDays(7))
                ->sum(DB::raw('transaction_items.quantity * inventory_batches.price')) ?? 0;

            // 4. Low Stock & Out of Stock
            $lowStocks = Item::where('quantity_on_hand', '>', 0)
                ->whereColumn('quantity_on_hand', '<=', 'low_stock_threshold')
                ->count();
                
            $outOfStock = Item::where('quantity_on_hand', 0)->count();

            return view('inventory_manager.inventory', compact(
                'items', 'categoryCount', 'totalProducts', 'revenue7Days', 
                'topSelling', 'cost7Days', 'lowStocks', 'outOfStock'
            ));
        }

    // This handles the "Add Product" Modal submission
    public function store(Request $request)
    {
        // 1. Validate the form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:items,sku',
            'unit_of_measure' => 'required|string',
            'price_per_unit' => 'required|numeric',
            'quantity_on_hand' => 'required|integer',
            'low_stock_threshold' => 'required|integer',
            'expiry_date' => 'nullable|date'
        ]);

        // 2. Save the Item
        $item = Item::create($validated);

        // 3. If quantity > 0, create the initial inventory batch for the expiry date
        if ($item->quantity_on_hand > 0) {
            InventoryBatch::create([
                'item_id' => $item->id,
                'quantity_remaining' => $item->quantity_on_hand,
                'price' => $item->price_per_unit,
                'expiry_date' => $request->expiry_date,
            ]);
        }

        // 4. Send them back to the inventory page
        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    // loads the individual item details page
    public function show(Item $item)
    {
        // Eager load batches to get the expiry date
        $item->load(['inventoryBatches' => function ($query) {
            $query->orderBy('expiry_date', 'asc');
        }]);

        return view('inventory_manager.item_details', compact('item'));
    }

    public function dashboard()
    {
        // 1. Sales Metrics
        $salesCount = DB::table('transactions')->count();
        $revenue = DB::table('transactions')->sum('total_amount');
        
        // Cost calculation (Sum of price_per_unit at time of sale * quantity sold)
        $cost = DB::table('transaction_items')
            ->join('inventory_batches', 'transaction_items.batch_id', '=', 'inventory_batches.id')
            ->sum(DB::raw('transaction_items.quantity * inventory_batches.price'));

        $profit = $revenue - $cost;

        // 2. Inventory Summaries
        $quantityInHand = Item::sum('quantity_on_hand');
        $toBeReceived = DB::table('supplier_infos')->sum('quantity_on_the_way');
        $supplierCount = DB::table('supplier_infos')->distinct('company_name')->count();
        $categoryCount = Item::whereNotNull('category')->distinct('category')->count();

        // 3. Low Stock List
        $lowStockItems = Item::whereColumn('quantity_on_hand', '<=', 'low_stock_threshold')
            ->where('quantity_on_hand', '>=', 0)
            ->get();

        // 4. Top Selling Items (Table in Dashboard)
        // We join transaction_items with Items to get names and pricing
        $topSelling = DB::table('transaction_items')
            ->join('items', 'transaction_items.item_id', '=', 'items.id')
            ->select('items.id', 'items.name', 'items.quantity_on_hand', 'items.price_per_unit', 
                    DB::raw('SUM(transaction_items.quantity) as total_sold'))
            ->groupBy('items.id', 'items.name', 'items.quantity_on_hand', 'items.price_per_unit')
            ->orderBy('total_sold', 'desc')
            ->limit(3)
            ->get();

        return view('inventory_manager.dashboard', compact(
            'salesCount', 'revenue', 'profit', 'cost', 
            'topSelling', 'quantityInHand', 'toBeReceived', 
            'supplierCount', 'categoryCount', 'lowStockItems'
        ));
    }
}