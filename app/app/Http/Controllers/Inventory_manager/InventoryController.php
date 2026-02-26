<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\InventoryBatch;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // This loads the Inventory page and passes the database items to it
    public function index()
    {
        // Get all items, paginated by 10 per page. 
        // We use 'with' to eagerly load the earliest expiry date from the batches table.
        $items = Item::with(['inventoryBatches' => function ($query) {
            $query->orderBy('expiry_date', 'asc');
        }])->paginate(10);
        
        // Calculate Stats for the top cards
        $totalProducts = Item::sum('quantity_on_hand');
        $lowStocks = Item::whereColumn('quantity_on_hand', '<=', 'low_stock_threshold')->count();
        $outOfStock = Item::where('quantity_on_hand', 0)->count();

        return view('inventory_manager.inventory', compact('items', 'totalProducts', 'lowStocks', 'outOfStock'));
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
}