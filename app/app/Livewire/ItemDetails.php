<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;

class ItemDetails extends Component
{
    public $itemId;
    public $activeTab = 'overview';
    public $item;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->item = Item::with('logisticItems.logisticLog', 'inventoryLogs', 'transactionItems')
            ->findOrFail($itemId);
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
