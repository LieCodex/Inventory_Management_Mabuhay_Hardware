<?php

namespace App\Livewire;

use App\Models\LogisticItem;
use App\Models\LogisticLog;
use App\Models\SupplierInfo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SupplierDeliveries extends Component
{
    public $supplierId;
    public $supplier;
    public $supplierCompany;
    public $suppliedItems = [];
    public $selected_item_id = '';

    // Add delivery form data
    public $logistic_company = '';
    public $expected_date = '';
    public $quantity = '';
    public $unit_cost = '';
    public $expiry_date = '';

    public function mount($supplierId)
    {
        $this->supplierId = $supplierId;
        $this->supplier = SupplierInfo::with('item')->findOrFail($supplierId);
        $this->supplierCompany = $this->supplier->company_name;
        $this->loadSuppliedItems();
        $this->selected_item_id = (string) ($this->suppliedItems[0]['id'] ?? '');
        $this->syncSupplierOnTheWay();
    }

    public function addDelivery()
    {
        $this->validate([
            'selected_item_id' => 'required|integer',
            'logistic_company' => 'required|string',
            'expected_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();
            $itemId = (int) $this->selected_item_id;

            if (!$this->isSuppliedItem($itemId)) {
                throw new \RuntimeException('Selected product is not linked to this supplier.');
            }

            $logisticLog = LogisticLog::create([
                'date' => $this->expected_date,
                'logistic_company' => $this->logistic_company,
            ]);

            LogisticItem::create([
                'logs_id' => $logisticLog->id,
                'item_id' => $itemId,
                'quantity' => $this->quantity,
                'unit_cost' => $this->unit_cost,
                'expiry_date' => !empty($this->expiry_date) ? $this->expiry_date : null,
                'supplier' => $this->supplierCompany,
                'status' => 'pending',
            ]);

            $this->syncSupplierOnTheWay();

            DB::commit();

            $this->reset(['logistic_company', 'expected_date', 'quantity', 'unit_cost', 'expiry_date']);
            session()->flash('success', 'Delivery added successfully!');
            $this->dispatch('deliveryAdded');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to add delivery: ' . $e->getMessage());
        }
    }

    public function markArrived($logisticItemId)
    {
        try {
            DB::beginTransaction();

            $logisticItem = LogisticItem::findOrFail($logisticItemId);
            if ($logisticItem->supplier !== $this->supplierCompany) {
                throw new \RuntimeException('Unauthorized delivery record.');
            }

            // Update item quantity on hand
            $item = $logisticItem->item;
            $item->quantity_on_hand += $logisticItem->quantity;
            $item->save();

            // Create inventory log for tracking
            $item->inventoryLogs()->create([
                'type' => 'purchase',
                'quantity_change' => $logisticItem->quantity,
                'remarks' => "Delivery from {$logisticItem->supplier} via {$logisticItem->logisticLog->logistic_company}",
            ]);

            // Keep record for history, just mark as accepted
            $logisticItem->status = 'accepted';
            $logisticItem->processed_at = now();
            $logisticItem->save();
            $this->syncSupplierOnTheWay();

            DB::commit();

            session()->flash('success', 'Delivery marked as arrived and stock updated!');
            $this->dispatch('deliveryUpdated');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to mark delivery as arrived: ' . $e->getMessage());
        }
    }

    public function returnDelivery($logisticItemId)
    {
        try {
            DB::beginTransaction();
            $logisticItem = LogisticItem::findOrFail($logisticItemId);
            if ($logisticItem->supplier !== $this->supplierCompany) {
                throw new \RuntimeException('Unauthorized delivery record.');
            }
            $logisticItem->status = 'rejected';
            $logisticItem->processed_at = now();
            $logisticItem->save();
            $this->syncSupplierOnTheWay();
            DB::commit();

            session()->flash('success', 'Delivery marked as returned.');
            $this->dispatch('deliveryUpdated');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to return delivery: ' . $e->getMessage());
        }
    }

    private function loadSuppliedItems(): void
    {
        $this->suppliedItems = SupplierInfo::with('item:id,name,sku')
            ->where('company_name', $this->supplierCompany)
            ->get()
            ->filter(fn ($row) => $row->item)
            ->map(fn ($row) => [
                'id' => $row->item->id,
                'name' => $row->item->name,
                'sku' => $row->item->sku,
            ])
            ->unique('id')
            ->values()
            ->all();
    }

    private function isSuppliedItem(int $itemId): bool
    {
        foreach ($this->suppliedItems as $item) {
            if ((int) $item['id'] === $itemId) {
                return true;
            }
        }

        return false;
    }

    private function syncSupplierOnTheWay(): void
    {
        $companySuppliers = SupplierInfo::where('company_name', $this->supplierCompany)->get();

        foreach ($companySuppliers as $supplierRow) {
            $baseQuery = LogisticItem::where('item_id', $supplierRow->item_id)
                ->where('supplier', $this->supplierCompany)
                ->where('status', 'pending')
                ->whereHas('logisticLog');

            $supplierRow->quantity_on_the_way = (int) $baseQuery->sum('quantity');
            $supplierRow->eta = (clone $baseQuery)
                ->join('logistic_logs', 'logistic_items.logs_id', '=', 'logistic_logs.id')
                ->min('logistic_logs.date');
            $supplierRow->save();
        }

        $this->supplier = SupplierInfo::with('item')->find($this->supplierId);
    }

    public function render()
    {
        $pendingDeliveries = LogisticItem::where('supplier', $this->supplierCompany)
            ->where('status', 'pending')
            ->with(['logisticLog', 'item'])
            ->orderByDesc('created_at')
            ->get();

        $pastDeliveries = DB::table('logistic_items')
            ->join('logistic_logs', 'logistic_items.logs_id', '=', 'logistic_logs.id')
            ->join('items', 'logistic_items.item_id', '=', 'items.id')
            ->where('logistic_items.supplier', $this->supplierCompany)
            ->whereIn('logistic_items.status', ['accepted', 'rejected'])
            ->select(
                'logistic_items.*',
                'logistic_logs.date as delivery_date',
                'logistic_logs.logistic_company',
                'items.name as item_name',
                'items.sku as item_sku'
            )
            ->orderByDesc('logistic_logs.date')
            ->paginate(10);

        return view('livewire.supplier-deliveries', [
            'suppliedItems' => $this->suppliedItems,
            'pendingDeliveries' => $pendingDeliveries,
            'pastDeliveries' => $pastDeliveries,
        ]);
    }
}
