<x-layouts::app :title="__('Inventory')">
    <div class="space-y-6" x-data="{ showAddProductModal: false, showFilters: {{ request()->hasAny(['availability', 'min_threshold', 'max_threshold', 'min_price', 'max_price']) ? 'true' : 'false' }} }">
        
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <livewire:dashboard-search />
                <div class="flex items-center gap-3">

                </div>
            </div>
        </div>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Overall Inventory</h2>
            
            <div class="grid grid-cols-2 gap-y-6 md:grid-cols-4 md:divide-x md:divide-zinc-200 dark:md:divide-zinc-700">
                <div class="flex flex-col md:px-6 md:first:pl-0 md:last:pr-0">
                    <p class="mb-2 text-sm font-medium text-sky-500">Categories</p>
                    <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ $categoryCount }}</p>
                    <p class="mt-1 text-xs text-zinc-500">All time</p>
                </div>
                
                <div class="flex flex-col md:px-6">
                    <p class="mb-2 text-sm font-medium text-amber-500">Total Items</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($totalProducts) }}</p>
                            <p class="mt-1 text-xs text-zinc-500">In Stock</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($revenue7Days, 2) }}</p>
                            <p class="mt-1 text-xs text-zinc-500">7-Day Revenue</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:px-6">
                    <p class="mb-2 text-sm font-medium text-indigo-500">Items Sold</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($topSelling) }}</p>
                            <p class="mt-1 text-xs text-zinc-500">Last 7 days</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($cost7Days, 2) }}</p>
                            <p class="mt-1 text-xs text-zinc-500">7-Day Cost</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:px-6">
                    <p class="mb-2 text-sm font-medium text-rose-500">Low Stocks</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ $lowStocks }}</p>
                            <p class="mt-1 text-xs text-zinc-500">Low Stock</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ $outOfStock }}</p>
                            <p class="mt-1 text-xs text-zinc-500">Not in stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Items</h2>
                
                <div class="flex items-center gap-3">
                    <button @click="showAddProductModal = true" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                        Add Item
                    </button>
                    <button @click="showFilters = !showFilters" class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                        Filters
                    </button>
                    <a href="{{ route('inventory_manager.inventory.export') }}" class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        Download all
                    </a>
                </div>
            </div>

            <div x-show="showFilters" style="display: none;" class="mb-5 rounded-lg border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/40">
                <form method="GET" action="{{ route('inventory_manager.inventory') }}" class="grid grid-cols-1 gap-3 md:grid-cols-5">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Availability</label>
                        <select name="availability" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            <option value="">All</option>
                            <option value="in_stock" {{ request('availability') === 'in_stock' ? 'selected' : '' }}>In-stock</option>
                            <option value="low_stock" {{ request('availability') === 'low_stock' ? 'selected' : '' }}>Low stock</option>
                            <option value="out_of_stock" {{ request('availability') === 'out_of_stock' ? 'selected' : '' }}>Out of stock</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Min Threshold</label>
                        <input type="number" name="min_threshold" value="{{ request('min_threshold') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Max Threshold</label>
                        <input type="number" name="max_threshold" value="{{ request('max_threshold') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Min Price</label>
                        <input type="number" step="0.01" name="min_price" value="{{ request('min_price') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Max Price</label>
                        <input type="number" step="0.01" name="max_price" value="{{ request('max_price') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                    </div>
                    <div class="md:col-span-5 flex justify-end gap-2 pt-1">
                        <a href="{{ route('inventory_manager.inventory') }}" class="rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">Reset</a>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Apply Filters</button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="py-3 font-medium">Items</th>
                            <th class="py-3 font-medium">Buying Price</th>
                            <th class="py-3 font-medium">Quantity</th>
                            <th class="py-3 font-medium">Threshold Value</th>
                            <th class="py-3 font-medium">Expiry Date</th>
                            <th class="py-3 font-medium">Availability</th>
                        </tr>
                    </thead>
                        <tbody class="text-zinc-700 dark:text-zinc-200">
                            @forelse($items as $item)
                                <tr 
                                    onclick="window.location='{{ route('inventory.show', $item->id) }}'" 
                                    class="border-t border-zinc-200 cursor-pointer transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800/50"
                                >
                                    <td class="py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $item->name }}</td>
                                    <td class="py-3">₱ {{ number_format($item->price_per_unit, 2) }}</td>
                                    <td class="py-3">{{ $item->quantity_on_hand }} {{ $item->unit_of_measure }}</td>
                                    <td class="py-3">{{ $item->low_stock_threshold }} {{ $item->unit_of_measure }}</td>
                                    <td class="py-3">
                                        @if($item->inventoryBatches->isNotEmpty() && $item->inventoryBatches->first()->expiry_date)
                                            {{ \Carbon\Carbon::parse($item->inventoryBatches->first()->expiry_date)->format('d/m/y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($item->quantity_on_hand == 0)
                                            <span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">Out of stock</span>
                                        @elseif($item->quantity_on_hand <= $item->low_stock_threshold)
                                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">Low stock</span>
                                        @else
                                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">In-stock</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-zinc-500">No products found in inventory.</td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
                
                @if ($items->onFirstPage())
                    <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                        Previous
                    </button>
                @else
                    <a href="{{ $items->previousPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Previous
                    </a>
                @endif

                <span class="text-sm text-zinc-500">Page {{ $items->currentPage() }} of {{ max(1, $items->lastPage()) }}</span>

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Next
                    </a>
                @else
                    <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                        Next
                    </button>
                @endif
                
            </div>
        </section>

        <div 
            x-show="showAddProductModal" 
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/50 p-4 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div 
                @click.away="showAddProductModal = false"
                class="w-full max-w-lg rounded-xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-700 dark:bg-zinc-900"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <h3 class="mb-6 text-lg font-semibold text-zinc-800 dark:text-zinc-100">New Item</h3>

                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="flex items-center gap-4">
                        <div class="flex h-20 w-20 items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-zinc-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="text-zinc-600 dark:text-zinc-400">Upload product image (optional)</p>
                            <input type="file" name="item_image" accept="image/*" class="mt-1 block w-full text-xs text-zinc-600 file:mr-2 file:rounded file:border-0 file:bg-emerald-50 file:px-2 file:py-1 file:text-emerald-700 hover:file:bg-emerald-100 dark:text-zinc-300 dark:file:bg-zinc-700 dark:file:text-zinc-100">
                            @error('item_image') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Item Name</label>
                        <input type="text" name="name" required placeholder="Enter item name" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Item ID (SKU)</label>
                        <input type="text" name="sku" required placeholder="Enter item ID" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Category</label>
                        <select name="category" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                            <option value="">Select item category</option>
                            @foreach($availableCategories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Buying Price</label>
                        <input type="number" step="0.01" name="price_per_unit" required placeholder="Enter buying price" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Quantity</label>
                        <input type="number" name="quantity_on_hand" required placeholder="Enter item quantity" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Unit</label>
                        <input type="text" name="unit_of_measure" required placeholder="e.g. pcs, bags" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Expiry Date</label>
                        <input type="date" name="expiry_date" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Threshold Value</label>
                        <input type="number" name="low_stock_threshold" required placeholder="Enter threshold value" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-2">
                        <button type="button" @click="showAddProductModal = false" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Discard
                        </button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                            Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>