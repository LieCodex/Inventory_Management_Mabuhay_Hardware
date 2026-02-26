<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\SupplierInfo;
use App\Models\Item;
use Illuminate\Http\Request;

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
}