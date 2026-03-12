<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\SupplierInfo;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class SupplierController extends Controller
{
    // Loads the page, fetches suppliers and the items for the dropdown
    public function index()
    {
        // Fetch suppliers and eager-load the item name to prevent N+1 query issues
        $suppliers = SupplierInfo::with('item')->paginate(10);
        
        // Fetch all items so we can populate the "Select Item" dropdown in the modal
        $items = Item::all(); 

        return view('inventory_manager.suppliers', compact('suppliers', 'items'));
    }

    // Handles the "Add Supplier" modal form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'item_id'        => 'required|exists:items,id',
            'contact_number' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
        ]);

        SupplierInfo::create($validated);

        return redirect()->route('inventory_manager.suppliers')->with('success', 'Supplier added successfully!');
    }

    public function show(SupplierInfo $supplier)
    {
        $supplier->load('item');

        // Fetch paginated delivery history for this specific supplier
        $deliveries = DB::table('logistic_items')
            ->join('logistic_logs', 'logistic_items.logs_id', '=', 'logistic_logs.id')
            ->where('logistic_items.item_id', $supplier->item_id)
            ->select('logistic_items.*', 'logistic_logs.date as delivery_date', 'logistic_logs.logistic_company')
            ->orderByDesc('logistic_logs.date')
            ->paginate(10); // Show 5 deliveries per page

        return view('inventory_manager.supplier_details', compact('supplier', 'deliveries'));
    }

    
}