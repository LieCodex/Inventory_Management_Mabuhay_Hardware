<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\SupplierInfo;

class DashboardSearch extends Component
{
    public $searchQuery = '';
    public $searchResults = [];
    public $showResults = false;

    public function updatedSearchQuery($value)
    {
        if (strlen($value) < 2) {
            $this->searchResults = [];
            $this->showResults = false;
            return;
        }

        $this->performSearch($value);
        $this->showResults = true;
    }

    private function performSearch($query)
    {
        $this->searchResults = [];

        
        // Now search
        $suppliers = SupplierInfo::with('item')
        ->where('company_name', 'like', '%' . $query . '%')
        ->limit(5) 
        ->get();

        $suppliersArray = $suppliers->map(function ($supplier) {
                return [
                    'type'     => 'supplier',
                    'id'       => $supplier->id,
                    'name'     => $supplier->company_name,
                    'subtitle' => 'Item: ' . ($supplier->item ? $supplier->item->name : 'Unknown') . ' | On the way: ' . $supplier->quantity_on_the_way,
                    'route'    => '/inventory-manager/suppliers/' . $supplier->id,
                ];
        })->toArray();
        // Search for items by name or SKU
        $items = Item::where('name', 'like', '%' . $query . '%')
            ->orWhere('sku', 'like', '%' . $query . '%')
            ->select('id', 'name', 'sku', 'quantity_on_hand')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'item',
                    'id' => $item->id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'subtitle' => 'SKU: ' . $item->sku . ' | Qty: ' . $item->quantity_on_hand,
                    'route' => route('inventory.show', $item->id),
                ];
            });

        // Search for items by supplier association (for deliveries)
        $itemsBySupplier = Item::where('name', 'like', '%' . $query . '%')
            ->orWhere('sku', 'like', '%' . $query . '%')
            ->with('inventoryBatches')
            ->has('inventoryBatches')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                $batch = $item->inventoryBatches->first();
                return [
                    'type' => 'delivery',
                    'id' => $item->id,
                    'name' => 'Delivery: ' . $item->name,
                    'subtitle' => 'Batch Price: ₱' . number_format($batch->price, 2) . ' | Expiry: ' . ($batch->expiry_date ? \Carbon\Carbon::parse($batch->expiry_date)->format('M d, Y') : 'N/A'),
                    'route' => route('inventory.show', $item->id),
                ];
            });

        // Merge in order: suppliers first, then items, then deliveries
        $this->searchResults = array_merge(
            $suppliersArray,
            $items->toArray(),
            $itemsBySupplier->toArray()
        );

        \Log::info('Final search results', [
            'total' => count($this->searchResults),
            'suppliers' => count($suppliersArray),
            'items' => count($items),
            'deliveries' => count($itemsBySupplier)
        ]);

        // Limit total results to 15
        $this->searchResults = array_slice($this->searchResults, 0, 15);
    }

    public function closeResults()
    {
        $this->showResults = false;
        $this->searchQuery = '';
    }

    public function render()
    {
        return view('livewire.dashboard-search');
    }
}
