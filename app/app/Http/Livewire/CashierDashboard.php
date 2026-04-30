<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\InventoryBatch;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CashierDashboard extends Component
{
    public string $search = '';
    public array $cart = [];
    public ?string $message = null;
    public ?string $error = null;

    public function mount(): void
    {
        $this->cart = [];
    }

    public function getFeaturedItemsProperty()
    {
        return Item::orderBy('name')
            ->limit(9)
            ->get(['id', 'name', 'sku', 'price_per_unit', 'quantity_on_hand']);
    }

    public function getSearchResultsProperty()
    {
        $term = trim($this->search);

        if ($term === '') {
            return collect();
        }

        return Item::where('sku', 'like', "%{$term}%")
            ->orWhere('barcode', 'like', "%{$term}%")
            ->orWhere('name', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'sku', 'price_per_unit', 'quantity_on_hand']);
    }

    public function updatedSearch(): void
    {
        $this->message = null;
        $this->error = null;
    }

    public function addItem(int $itemId, int $quantity = 1): void
    {
        $item = Item::find($itemId);

        if (! $item) {
            $this->error = 'Item not found.';
            return;
        }

        if ($item->quantity_on_hand <= 0) {
            $this->error = 'This item is out of stock.';
            return;
        }

        if (! isset($this->cart[$item->id])) {
            $this->cart[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'sku' => $item->sku,
                'price' => (float) $item->price_per_unit,
                'quantity' => 0,
                'uom' => $item->unit_of_measure,
                'subtotal' => 0.0,
            ];
        }

        $this->cart[$item->id]['quantity'] += $quantity;
        $this->recalculateItem($item->id);

        $this->message = "Added \"{$item->name}\" to the basket.";
        $this->error = null;
        $this->search = '';
    }

    public function addByBarcode(): void
    {
        $term = trim($this->search);

        if ($term === '') {
            return;
        }

        $item = Item::where('barcode', $term)
            ->orWhere('sku', $term)
            ->first();

        if (! $item) {
            $this->error = 'No item matches that barcode or SKU.';
            return;
        }

        $this->addItem($item->id);
    }

    public function removeItem(int $itemId): void
    {
        if (isset($this->cart[$itemId])) {
            unset($this->cart[$itemId]);
        }

        $this->message = null;
        $this->error = null;
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        if (! isset($this->cart[$itemId])) {
            return;
        }

        if ($quantity <= 0) {
            $this->removeItem($itemId);
            return;
        }

        $this->cart[$itemId]['quantity'] = $quantity;
        $this->recalculateItem($itemId);
    }

    protected function recalculateItem(int $itemId): void
    {
        if (! isset($this->cart[$itemId])) {
            return;
        }

        $this->cart[$itemId]['subtotal'] = round($this->cart[$itemId]['price'] * $this->cart[$itemId]['quantity'], 2);
    }

    public function getTotalProperty(): float
    {
        return round(array_sum(array_column($this->cart, 'subtotal')), 2);
    }

public function checkout(): void
{
    if (empty($this->cart)) {
        $this->error = 'The basket is empty.';
        return;
    }
    $transactionTotal = round(array_sum(array_column($this->cart, 'subtotal')), 2);
    DB::transaction(function () use ($transactionTotal) {
        /** @var Transaction $transaction */
        $transaction = Transaction::create([
            'total_amount' => $transactionTotal,
            'transaction_date' => now(),
        ]);

        foreach ($this->cart as $item) {
            $batchId = $this->consumeInventory($item['id'], $item['quantity']);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_id' => $item['id'],
                'batch_id' => $batchId,
                'quantity' => $item['quantity'],
                'price_at_sale' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            Item::where('id', $item['id'])->decrement('quantity_on_hand', $item['quantity']);
        }
    });

    // 3. Clear the cart. Since getTotalProperty() was never called, 
    // the view will calculate it fresh and see 0.00!
    $this->cart = [];
    $this->message = 'Sale completed successfully.';
    $this->error = null;
}

    protected function consumeInventory(int $itemId, int $quantity): ?int
    {
        $remaining = $quantity;
        $lastBatchId = null;

        while ($remaining > 0) {
            $batch = InventoryBatch::where('item_id', $itemId)
                ->where('quantity_remaining', '>', 0)
                ->orderBy('expiry_date')
                ->first();

            if (! $batch) {
                break;
            }

            $consume = min($remaining, $batch->quantity_remaining);
            $batch->decrement('quantity_remaining', $consume);

            $remaining -= $consume;
            $lastBatchId = $batch->id;
        }

        return $lastBatchId;
    }

    public function render()
    {
        return view('livewire.cashier-dashboard');
    }
}
