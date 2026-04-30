<?php
namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class ReceiptViewer extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $selectedTransactionId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->selectedTransactionId = null;
    }

    public function viewReceipt(int $id): void
    {
        $this->selectedTransactionId = $id;
    }

    public function closeReceipt(): void
    {
        $this->selectedTransactionId = null;
    }

    public function getSelectedTransactionProperty()
    {
        if (! $this->selectedTransactionId) {
            return null;
        }

        return Transaction::with('items.item')
            ->find($this->selectedTransactionId);
    }

    public function render()
    {
        $transactions = Transaction::query()
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        return view('livewire.receipt-viewer', [
            'transactions' => $transactions
        ]);
    }
}