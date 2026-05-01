<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Item;
use App\Models\InventoryLog;

class ItemDetails extends Component
{
    public $itemId;
    public $activeTab = 'overview';
    public $item;
    public $showEditModal = false;
    public $name;
    public $sku;
    public $category;
    public $description;
    public $unit_of_measure;
    public $price_per_unit;
    public $quantity_on_hand;
    public $low_stock_threshold;
    public $recentDeliveryPrice;
    public $recentDeliveryDate;
    public $recentDeliverySupplier;
    public $availableCategories = [];

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->item = Item::with('logisticItems.logisticLog', 'inventoryLogs', 'transactionItems')
            ->findOrFail($itemId);

        $this->loadAvailableCategories();
        $this->fillItemFields();
        $this->loadRecentDeliveryReference();
    }

    protected function loadAvailableCategories()
    {
        $this->availableCategories = Item::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values()
            ->toArray();
    }

    protected function fillItemFields()
    {
        $this->name = $this->item->name;
        $this->sku = $this->item->sku;
        $this->category = $this->item->category;
        $this->description = $this->item->description;
        $this->unit_of_measure = $this->item->unit_of_measure;
        $this->price_per_unit = $this->item->price_per_unit;
        $this->quantity_on_hand = $this->item->quantity_on_hand;
        $this->low_stock_threshold = $this->item->low_stock_threshold;
    }

    protected function loadRecentDeliveryReference()
    {
        $latestDelivery = $this->item->logisticItems()
            ->whereNotNull('unit_cost')
            ->orderByDesc('created_at')
            ->first();

        if ($latestDelivery) {
            $this->recentDeliveryPrice = $latestDelivery->unit_cost;
            $this->recentDeliveryDate = optional($latestDelivery->created_at)->format('M d, Y');
            $this->recentDeliverySupplier = $latestDelivery->supplier;
        }
    }

    public function openEditModal()
    {
        $this->fillItemFields();
        $this->loadRecentDeliveryReference();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    public function updateItem()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                Rule::unique('items', 'sku')->ignore($this->itemId),
            ],
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit_of_measure' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'quantity_on_hand' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        // Track changes to log them
        $changes = [];
        $fieldLabels = [
            'name' => 'Name',
            'sku' => 'SKU',
            'category' => 'Category',
            'description' => 'Description',
            'unit_of_measure' => 'Unit of Measure',
            'price_per_unit' => 'Buying Price',
            'quantity_on_hand' => 'Quantity',
            'low_stock_threshold' => 'Threshold',
        ];

        foreach ($validated as $field => $newValue) {
            $oldValue = $this->item->$field;
            if ($oldValue != $newValue) {
                $changes[] = "{$fieldLabels[$field]}: {$oldValue} → {$newValue}";
            }
        }

        $this->item->update($validated);

        // Log the changes
        if (!empty($changes)) {
            InventoryLog::create([
                'item_id' => $this->item->id,
                'type' => 'item_details',
                'quantity_change' => 0,
                'remarks' => implode(' | ', $changes),
            ]);
        }

        $this->item->refresh();
        $this->fillItemFields();
        $this->loadRecentDeliveryReference();
        $this->showEditModal = false;

        session()->flash('success', 'Item details updated successfully.');
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.item-details', [
            'item' => $this->item,
            'purchases' => $this->item->logisticItems()->with('logisticLog')->orderByDesc('created_at')->get(),
            'adjustments' => $this->item->adjustmentLogs()->orderByDesc('created_at')->get(),
            'allHistory' => $this->item->inventoryLogs()->orderByDesc('created_at')->get(),
            'sales' => $this->item->transactionItems()->with('item')->orderByDesc('created_at')->get(),
        ]);
    }
}
