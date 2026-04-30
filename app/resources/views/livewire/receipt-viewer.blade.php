<div class="space-y-4">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div>
            <h1 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Transaction History</h1>
            <p class="text-sm text-zinc-500">View and reprint past receipts.</p>
        </div>
        <div class="w-full max-w-sm">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by Order ID..."
                class="w-full"
            />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
                    <thead class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-100">
                        <tr>
                            <th class="p-3">Order ID</th>
                            <th class="p-3">Date & Time</th>
                            <th class="p-3">Total Amount</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="p-3 font-medium">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y h:i A') }}</td>
                                <td class="p-3">₱ {{ number_format($transaction->total_amount, 2) }}</td>
                                <td class="p-3 text-right">
                                    <flux:button size="sm" variant="outline" wire:click="viewReceipt({{ $transaction->id }})">
                                        View
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-zinc-500">No transactions found matching that ID.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            @if($this->selectedTransaction)
                <div class="flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Receipt Details</h2>
                    <button wire:click.prevent="closeReceipt" class="text-zinc-400 hover:text-rose-500 transition">✕</button>
                </div>

                <div class="mt-4 space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold uppercase tracking-wider text-zinc-800 dark:text-zinc-100">Mabuhay Hardware</h3>
                        <p class="text-xs text-zinc-500 uppercase tracking-widest">Official Receipt</p>
                    </div>

                    <div class="flex justify-between text-sm text-zinc-600 dark:text-zinc-300">
                        <span>Order: #{{ str_pad($this->selectedTransaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span>{{ \Carbon\Carbon::parse($this->selectedTransaction->transaction_date)->format('m/d/Y H:i') }}</span>
                    </div>

                    <div class="border-y border-dashed border-zinc-300 py-3 dark:border-zinc-600">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-zinc-500">
                                    <th class="pb-2 text-left font-normal">Item</th>
                                    <th class="pb-2 text-center font-normal">Qty</th>
                                    <th class="pb-2 text-right font-normal">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->selectedTransaction->items as $item)
                                    <tr class="text-zinc-800 dark:text-zinc-200">
                                        <td class="py-1.5">
                                            <div class="font-medium">{{ $item->item->name ?? 'Unknown Item' }}</div>
                                            <div class="text-xs text-zinc-500">@ ₱{{ number_format($item->price_at_sale, 2) }}</div>
                                        </td>
                                        <td class="py-1.5 text-center align-top">{{ $item->quantity }}</td>
                                        <td class="py-1.5 text-right align-top">₱{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between pt-2 text-lg font-bold text-zinc-800 dark:text-zinc-100">
                        <span>Total</span>
                        <span>₱ {{ number_format($this->selectedTransaction->total_amount, 2) }}</span>
                    </div>
                </div>
            @else
                <div class="flex h-full flex-col items-center justify-center space-y-3 py-16 text-center text-zinc-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-300 dark:text-zinc-700"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    <p>Select a transaction to view its receipt.</p>
                </div>
            @endif
        </div>
    </div>
</div>