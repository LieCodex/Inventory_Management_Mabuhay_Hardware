<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-4">
        {{-- Search & Profile Header --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <livewire:dashboard-search />
                </div>
                <div class="flex items-center gap-3">
                    
                    
                </div>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <div class="space-y-4 xl:col-span-2">
                
                {{-- Sales Overview --}}
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Sales Overview</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Sales (Receipts)</p>
                            <p class="mt-1 text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($salesCount) }}</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Revenue</p>
                            <p class="mt-1 text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($revenue, 2) }}</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Profit</p>
                            <p class="mt-1 text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($profit, 2) }}</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Cost</p>
                            <p class="mt-1 text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($cost, 2) }}</p>
                        </div>
                    </div>
                </section>

                {{-- Sales & Purchase Chart --}}
                <livewire:sales-and-purchases-chart />

                {{-- Top Selling Stock --}}
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Top Selling Stock</h2>
                        <a href="{{ route('inventory.index') }}" class="text-sm text-emerald-600 hover:underline">See All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-zinc-500">
                                <tr>
                                    <th class="py-2">Name</th>
                                    <th class="py-2 text-center">Sold Quantity</th>
                                    <th class="py-2 text-center">Remaining Quantity</th>
                                    <th class="py-2 text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-zinc-700 dark:text-zinc-200">
                                @forelse($topSelling as $sale)
                                    <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                        <td class="py-2">{{ $sale->item->name ?? 'Unknown Item' }}</td>
                                        <td class="py-2 text-center">{{ $sale->total_sold }}</td>
                                        <td class="py-2 text-center">{{ $sale->item->quantity_on_hand ?? 0 }}</td>
                                        <td class="py-2 text-right">₱ {{ number_format($sale->item->price_per_unit ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-zinc-500">No sales data available yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            {{-- Sidebar Column --}}
            <div class="space-y-4">
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Inventory Summary</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Quantity in Hand</p>
                            <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($quantityInHand) }}</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">To be received</p>
                            <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ number_format($toBeReceived) }}</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Item Summary</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Number of Suppliers</p>
                            <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ $supplierCount }}</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Categories</p>
                            <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ $categoryCount }}</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Low Quantity Stock</h2>
                    <div class="space-y-3 text-sm mt-4">
                        @forelse($lowStockItems as $item)
                            <div class="flex items-center justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                                <div>
                                    <p class="font-medium text-zinc-800 dark:text-zinc-100">{{ $item->name }}</p>
                                    <p class="text-xs text-zinc-500">Remaining Quantity: {{ $item->quantity_on_hand }} {{ $item->unit_of_measure }}</p>
                                </div>
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $item->quantity_on_hand == 0 ? 'bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' }}">
                                    {{ $item->quantity_on_hand == 0 ? 'Empty' : 'Low' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-sm text-zinc-500 py-4">All stock levels look good!</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-layouts::app>