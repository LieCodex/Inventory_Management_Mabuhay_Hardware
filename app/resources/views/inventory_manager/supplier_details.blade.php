<x-layouts::app :title="$supplier->company_name . ' - Details'">
    <div class="space-y-6" x-data="{ activeTab: new URLSearchParams(location.search).has('page') ? 'deliveries' : 'overview' }">
        
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="w-full max-w-xl">
                    <input
                        type="text"
                        placeholder="Search item, supplier, order"
                        class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm outline-none ring-emerald-500 placeholder:text-zinc-400 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    >
                </div>
                <div class="flex items-center gap-3">
                    <div class="cursor-pointer rounded-full border border-zinc-200 p-2 text-zinc-500 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75v-.7V9a6 6 0 1 0-12 0v.05-.001v.7a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('inventory_manager.suppliers') }}" class="text-zinc-400 hover:text-emerald-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">{{ $supplier->company_name }}</h2>
                </div>
                
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                        Edit
                    </button>
                    <button class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        Contact Supplier
                    </button>
                </div>
            </div>

            <div class="mb-8 flex space-x-8 border-b border-zinc-200 dark:border-zinc-800">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'" 
                        class="border-b-2 pb-4 text-sm font-medium transition-colors">
                    Overview
                </button>
                <button @click="activeTab = 'deliveries'" 
                        :class="activeTab === 'deliveries' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'" 
                        class="border-b-2 pb-4 text-sm font-medium transition-colors">
                    Deliveries
                </button>
                <button @click="activeTab = 'logs'" 
                        :class="activeTab === 'logs' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'" 
                        class="border-b-2 pb-4 text-sm font-medium transition-colors">
                    Logs
                </button>
            </div>

            <div x-show="activeTab === 'overview'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid gap-12 lg:grid-cols-2">
                
                <div class="space-y-8">
                    <div>
                        <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Supplier Information</h3>
                        <div class="space-y-4 text-sm">
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Company Name</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->company_name }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Contact Number</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->contact_number }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Email Address</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->email ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Supplied Item Details</h3>
                        <div class="space-y-4 text-sm">
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Item Name</span>
                                <span class="font-medium text-emerald-600 hover:underline dark:text-emerald-400">
                                    @if($supplier->item)
                                        <a href="{{ route('inventory.show', $supplier->item->id) }}">{{ $supplier->item->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Item SKU</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->item->sku ?? 'N/A' }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Category</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->item->category ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center sm:items-end">
                    <div class="mb-8 flex h-48 w-48 items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>

                    <div class="w-full max-w-sm space-y-6 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">On the way</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $supplier->quantity_on_the_way }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">ETA</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                {{ $supplier->eta ? \Carbon\Carbon::parse($supplier->eta)->format('M d, Y') : 'No active deliveries' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
                            <span class="text-zinc-500">Current Store Stock</span>
                            <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                {{ $supplier->item->quantity_on_hand ?? 0 }} {{ $supplier->item->unit_of_measure ?? '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'deliveries'" style="display: none;" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <h3 class="mb-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Delivery History</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-zinc-500 border-b border-zinc-200 dark:border-zinc-800">
                            <tr>
                                <th class="py-3 font-medium">Date Received</th>
                                <th class="py-3 font-medium">Logistics Company</th>
                                <th class="py-3 font-medium">Quantity</th>
                                <th class="py-3 font-medium">Unit Cost</th>
                                <th class="py-3 font-medium text-right">Total Cost</th>
                            </tr>
                        </thead>
                        <tbody class="text-zinc-700 dark:text-zinc-200 divide-y divide-zinc-100 dark:divide-zinc-800/50">
                            @forelse($deliveries as $delivery)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-3">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y') }}</td>
                                    <td class="py-3">{{ $delivery->logistic_company }}</td>
                                    <td class="py-3">{{ $delivery->quantity }}</td>
                                    <td class="py-3">₱{{ number_format($delivery->unit_cost, 2) }}</td>
                                    <td class="py-3 text-right font-medium">₱{{ number_format($delivery->quantity * $delivery->unit_cost, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-zinc-500">No past deliveries found for this supplier.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    
                    @if ($deliveries->onFirstPage())
                        <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            Previous
                        </button>
                    @else
                        <a href="{{ $deliveries->previousPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                            Previous
                        </a>
                    @endif

                    <span class="text-sm text-zinc-500">Page {{ $deliveries->currentPage() }} of {{ max(1, $deliveries->lastPage()) }}</span>

                    @if ($deliveries->hasMorePages())
                        <a href="{{ $deliveries->nextPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                            Next
                        </a>
                    @else
                        <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            Next
                        </button>
                    @endif
                    
                </div>
            </div>

            <div x-show="activeTab === 'logs'" style="display: none;" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                    <p class="text-sm text-zinc-500">No logs generated yet.</p>
                </div>
            </div>

        </div>
    </div>
</x-layouts::app>