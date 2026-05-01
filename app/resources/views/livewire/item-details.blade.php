<div class="space-y-6">
    <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <livewire:dashboard-search />
            <div class="flex items-center gap-3">

            </div>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('inventory.index') }}" class="text-zinc-400 hover:text-emerald-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">{{ $item->name }}</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <button wire:click="openEditModal" class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                    Edit
                </button>
                <button class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    Download
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-8 flex space-x-8 border-b border-zinc-200 dark:border-zinc-800 overflow-x-auto">
            <button 
                wire:click="switchTab('overview')"
                class="border-b-2 pb-4 text-sm font-medium transition-colors whitespace-nowrap {{ $activeTab === 'overview' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                Overview
            </button>
            <button 
                wire:click="switchTab('purchases')"
                class="border-b-2 pb-4 text-sm font-medium transition-colors whitespace-nowrap {{ $activeTab === 'purchases' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                Purchases
            </button>
            <button 
                wire:click="switchTab('adjustments')"
                class="border-b-2 pb-4 text-sm font-medium transition-colors whitespace-nowrap {{ $activeTab === 'adjustments' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                Adjustments
            </button>
            <button 
                wire:click="switchTab('history')"
                class="border-b-2 pb-4 text-sm font-medium transition-colors whitespace-nowrap {{ $activeTab === 'history' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                History
            </button>
        </div>

        <!-- Overview Tab -->
        @if($activeTab === 'overview')
        <div>
            <div class="grid gap-12 lg:grid-cols-2">
                <div class="space-y-8">
                    <div>
                        <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Primary Details</h3>
                        <div class="space-y-4 text-sm">
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Product name</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->name }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Product ID</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->sku }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Product category</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->category ?? 'Small Items' }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Expiry Date</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                    @if($item->inventoryBatches->isNotEmpty() && $item->inventoryBatches->first()->expiry_date)
                                        {{ \Carbon\Carbon::parse($item->inventoryBatches->first()->expiry_date)->format('M d, Y') }}
                                    @else
                                        None
                                    @endif
                                </span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Threshold Value</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->low_stock_threshold }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Supplier Details</h3>
                        <div class="space-y-4 text-sm">
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Supplier name</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">Ronald Martin</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Contact Number</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">09123456789</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center sm:items-end">
                    <div class="mb-8 flex h-48 w-48 items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                        @if($item->image_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full rounded-xl object-cover" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        @endif
                    </div>

                    <div class="w-full max-w-sm space-y-6 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Opening Stock</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">40</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Remaining Stock</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->quantity_on_hand }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">On the way</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">15</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Threshold value</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->low_stock_threshold }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Purchases Tab -->
        @if($activeTab === 'purchases')
        <div>
            @if($purchases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Date</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Supplier</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Quantity</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Unit Cost</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Total Cost</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Expiry Date</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Logistic Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr class="border-b border-zinc-100 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $purchase->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $purchase->supplier ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $purchase->quantity }}</td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">₱{{ number_format($purchase->unit_cost, 2) }}</td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">₱{{ number_format($purchase->quantity * $purchase->unit_cost, 2) }}</td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                        @if($purchase->expiry_date)
                                            {{ \Carbon\Carbon::parse($purchase->expiry_date)->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $purchase->logisticLog->logistic_company ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m0 0C5.306 7.693 3.75 9.15 3.75 10.5v7.125c0 2.278 3.694 4.125 8.25 4.125s8.25-1.847 8.25-4.125v-7.125c0-1.35-1.556-2.807-3.75-4.125" />
                    </svg>
                    <p class="mt-4 text-zinc-500">No purchase records found</p>
                </div>
            @endif
        </div>
        @endif

        <!-- Adjustments Tab -->
        @if($activeTab === 'adjustments')
        <div>
            @if($adjustments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Date</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Type</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Change Details</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Quantity Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adjustments as $adjustment)
                                <tr class="border-b border-zinc-100 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $adjustment->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3">
                                        @if($adjustment->type === 'item_details')
                                            <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                                Item Details
                                            </span>
                                        @else
                                            <span class="inline-block rounded-full px-3 py-1 text-xs font-medium {{ $adjustment->quantity_change > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' }}">
                                                {{ ucfirst($adjustment->type) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                        @if($adjustment->type === 'item_details')
                                            <div class="space-y-1">
                                                @foreach(explode(' | ', $adjustment->remarks ?? '') as $change)
                                                    <div class="text-xs">{{ trim($change) }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            {{ $adjustment->remarks ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($adjustment->type !== 'item_details')
                                            <span class="{{ $adjustment->quantity_change > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                                {{ $adjustment->quantity_change > 0 ? '+' : '' }}{{ $adjustment->quantity_change }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <p class="mt-4 text-zinc-500">No adjustment records found</p>
                </div>
            @endif
        </div>
        @endif

        <!-- History Tab -->
        @if($activeTab === 'history')
        <div>
            @if($allHistory->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Date & Time</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Event Type</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Quantity Change</th>
                                <th class="px-4 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-300">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allHistory as $log)
                                <tr class="border-b border-zinc-100 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $log->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full px-3 py-1 text-xs font-medium 
                                            @if($log->type === 'purchase')
                                                bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300
                                            @elseif($log->type === 'sale')
                                                bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300
                                            @elseif($log->type === 'adjustment')
                                                bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300
                                            @else
                                                bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300
                                            @endif
                                        ">
                                            {{ ucfirst($log->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $log->quantity_change > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                            {{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $log->remarks ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                    </svg>
                    <p class="mt-4 text-zinc-500">No history records found</p>
                </div>
            @endif
        </div>
        @endif
    </div>

    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Edit Item</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Update item details and reference the most recent purchase price.</p>
                    </div>
                    <button type="button" wire:click="closeEditModal" class="text-zinc-500 transition hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">✕</button>
                </div>

                @if($recentDeliveryPrice)
                    <div class="mb-4 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-200">
                        Most recent delivery paid: <strong>₱{{ number_format($recentDeliveryPrice, 2) }}</strong> per unit
                        @if($recentDeliveryDate)
                            on {{ $recentDeliveryDate }}
                        @endif
                        @if($recentDeliverySupplier)
                            from {{ $recentDeliverySupplier }}
                        @endif
                    </div>
                @endif

                <form wire:submit.prevent="updateItem" class="grid gap-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Item Name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Item ID (SKU)</label>
                            <input type="text" wire:model.defer="sku" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('sku') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Category</label>
                            <select wire:model.defer="category" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                <option value="">Select item category</option>
                                @foreach($availableCategories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Unit</label>
                            <input type="text" wire:model.defer="unit_of_measure" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('unit_of_measure') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Buying Price</label>
                            <input type="number" step="0.01" wire:model.defer="price_per_unit" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('price_per_unit') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Quantity</label>
                            <input type="number" wire:model.defer="quantity_on_hand" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('quantity_on_hand') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Threshold Value</label>
                            <input type="number" wire:model.defer="low_stock_threshold" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('low_stock_threshold') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Description</label>
                            <input type="text" wire:model.defer="description" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="closeEditModal" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                            Cancel
                        </button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

