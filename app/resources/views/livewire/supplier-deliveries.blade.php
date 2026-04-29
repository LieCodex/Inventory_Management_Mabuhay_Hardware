<div class="space-y-6" x-data="{ showModal: false }" x-on:delivery-added.window="showModal = false">
    @if(session()->has('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-900/20 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Delivery Button -->
    <div class="flex justify-end">
        <button @click="showModal = true" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-block w-4 h-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New Delivery
        </button>
    </div>

    <!-- Pending Deliveries Section -->
    @if($pendingDeliveries->count() > 0)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-6 dark:border-amber-900/50 dark:bg-amber-900/20">
            <h3 class="mb-4 text-lg font-semibold text-amber-900 dark:text-amber-300">Pending Deliveries</h3>
            <div class="space-y-3">
                @foreach($pendingDeliveries as $delivery)
                    <div class="flex flex-col gap-3 rounded-lg border border-amber-200 bg-white p-4 dark:border-amber-900/30 dark:bg-zinc-800 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                {{ $delivery->quantity }} units @ ₱{{ number_format($delivery->unit_cost, 2) }}/unit
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Item: {{ $delivery->item->name ?? 'N/A' }} @if(!empty($delivery->item->sku)) ({{ $delivery->item->sku }}) @endif
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $delivery->logisticLog->logistic_company }} • 
                                Expected: {{ \Carbon\Carbon::parse($delivery->logisticLog->date)->format('M d, Y') }}
                                @if($delivery->expiry_date)
                                    • Expires: {{ \Carbon\Carbon::parse($delivery->expiry_date)->format('M d, Y') }}
                                @endif
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button 
                                wire:click="markArrived({{ $delivery->id }})"
                                wire:confirm="Mark this delivery as arrived and add to stock?"
                                class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                                ✓ Arrived
                            </button>
                            <button 
                                wire:click="returnDelivery({{ $delivery->id }})"
                                wire:confirm="Mark this delivery as returned?"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                                ✕ Return
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Past Deliveries Table -->
    <div>
        <h3 class="mb-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Delivery History</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-zinc-500 border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 font-medium">Date Received</th>
                        <th class="py-3 font-medium">Product</th>
                        <th class="py-3 font-medium">Logistics Company</th>
                        <th class="py-3 font-medium">Quantity</th>
                        <th class="py-3 font-medium">Unit Cost</th>
                        <th class="py-3 font-medium">Status</th>
                        <th class="py-3 font-medium text-right">Total Cost</th>
                    </tr>
                </thead>
                <tbody class="text-zinc-700 dark:text-zinc-200 divide-y divide-zinc-100 dark:divide-zinc-800/50">
                    @forelse($pastDeliveries as $delivery)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="py-3">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y') }}</td>
                            <td class="py-3">{{ $delivery->item_name }} @if($delivery->item_sku) ({{ $delivery->item_sku }}) @endif</td>
                            <td class="py-3">{{ $delivery->logistic_company }}</td>
                            <td class="py-3">{{ $delivery->quantity }}</td>
                            <td class="py-3">₱{{ number_format($delivery->unit_cost, 2) }}</td>
                            <td class="py-3">
                                @if($delivery->status === 'accepted')
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        Accepted
                                    </span>
                                @elseif($delivery->status === 'rejected')
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ ucfirst($delivery->status ?? 'unknown') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-right font-medium">₱{{ number_format($delivery->quantity * $delivery->unit_cost, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-zinc-500">No past deliveries found for this supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
            @if ($pastDeliveries->onFirstPage())
                <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    Previous
                </button>
            @else
                <a href="{{ $pastDeliveries->previousPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Previous
                </a>
            @endif

            <span class="text-sm text-zinc-500">Page {{ $pastDeliveries->currentPage() }} of {{ max(1, $pastDeliveries->lastPage()) }}</span>

            @if ($pastDeliveries->hasMorePages())
                <a href="{{ $pastDeliveries->nextPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Next
                </a>
            @else
                <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    Next
                </button>
            @endif
        </div>
    </div>

    <!-- Add Delivery Modal -->
    <div 
        x-show="showModal"
        @keydown.escape="showModal = false"
        @click.self="showModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="w-full max-w-md rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900 shadow-xl" @click.stop x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Add New Delivery</h3>
                <button @click="showModal = false" type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="addDelivery" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Product</label>
                    <select
                        wire:model="selected_item_id"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    >
                        <option value="">Select product...</option>
                        @foreach($suppliedItems as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }} ({{ $item['sku'] ?? 'No SKU' }})</option>
                        @endforeach
                    </select>
                    @error('selected_item_id') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Logistic Company</label>
                    <input 
                        type="text" 
                        wire:model="logistic_company" 
                        placeholder="e.g., DHL, FedEx, Local Courier"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 placeholder-zinc-400 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-500"
                    />
                    @error('logistic_company') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Expected Delivery Date</label>
                    <input 
                        type="date" 
                        wire:model="expected_date"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    />
                    @error('expected_date') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Quantity</label>
                        <input 
                            type="number" 
                            wire:model="quantity" 
                            placeholder="0"
                            min="1"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 placeholder-zinc-400 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-500"
                        />
                        @error('quantity') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Unit Cost (₱)</label>
                        <input 
                            type="number" 
                            wire:model="unit_cost" 
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 placeholder-zinc-400 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-500"
                        />
                        @error('unit_cost') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Expiry Date (Optional)</label>
                    <input 
                        type="date" 
                        wire:model="expiry_date"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    />
                    @error('expiry_date') <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="showModal = false" class="flex-1 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                <button type="submit" class="flex-1 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                    Add Delivery
                </button>
                </div>
            </form>
        </div>
    </div>
</div>
