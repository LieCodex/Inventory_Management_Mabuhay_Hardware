<x-layouts::app :title="__('Suppliers')">
    <div class="space-y-6" x-data="{ showAddSupplierModal: false }">
        
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="w-full max-w-xl">
                    <input
                        type="text"
                        placeholder="Search item, supplier, deliveries"
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

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Suppliers</h2>
                
                <div class="flex items-center gap-3">
                    <button @click="showAddSupplierModal = true" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                        Add Supplier
                    </button>
                    <button class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                        Filters
                    </button>
                    <button class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        Download all
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="py-3 font-medium">Supplier Company</th>
                            <th class="py-3 font-medium">Item</th>
                            <th class="py-3 font-medium">Contact Number</th>
                            <th class="py-3 font-medium">Email</th>
                            <th class="py-3 text-center font-medium">On the way</th>
                            <th class="py-3 text-right font-medium leading-tight">Expected Date<br>of Arrival</th>
                        </tr>
                    </thead>
                        <tbody class="text-zinc-700 dark:text-zinc-200">
                            @forelse($suppliers as $supplier)
                                <tr 
                                    onclick="window.location='{{ route('inventory_manager.suppliers.show', $supplier->id) }}'" 
                                    class="border-t border-zinc-100 cursor-pointer transition-colors hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50"
                                >
                                    <td class="py-4 font-medium">{{ $supplier->company_name }}</td>
                                    <td class="py-4">{{ $supplier->item ? $supplier->item->name : 'N/A' }}</td>
                                    <td class="py-4">{{ $supplier->contact_number }}</td>
                                    <td class="py-4">{{ $supplier->email ?? 'No email' }}</td>
                                    <td class="py-4 text-center">{{ $supplier->quantity_on_the_way > 0 ? $supplier->quantity_on_the_way : '-' }}</td>
                                    <td class="py-4 text-right">
                                        {{ $supplier->eta ? \Carbon\Carbon::parse($supplier->eta)->format('d/m/y') : 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-zinc-500">No suppliers found. Add one to get started!</td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
                @if ($suppliers->onFirstPage())
                    <button disabled class="cursor-not-allowed opacity-50 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                        Previous
                    </button>
                @else
                    <a href="{{ $suppliers->previousPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Previous
                    </a>
                @endif

                <span class="text-sm text-zinc-500">Page {{ $suppliers->currentPage() }} of {{ max(1, $suppliers->lastPage()) }}</span>

                @if ($suppliers->hasMorePages())
                    <a href="{{ $suppliers->nextPageUrl() }}" class="inline-block rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
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
            x-show="showAddSupplierModal" 
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
                @click.away="showAddSupplierModal = false"
                class="w-full max-w-lg rounded-xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-700 dark:bg-zinc-900"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <h3 class="mb-6 text-lg font-semibold text-zinc-800 dark:text-zinc-100">New Supplier</h3>

                <form action="{{ route('inventory_manager.suppliers.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Company Name</label>
                        <input type="text" name="company_name" required placeholder="Enter company name" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Supplied Item</label>
                            <select name="item_id" required class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <option value="">Select product...</option>
                                
                                @forelse($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sku }})</option>
                                @empty
                                    <option value="" disabled>⚠️ No products found! Add items in Inventory first.</option>
                                @endforelse
                            </select>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Contact Number</label>
                        <input type="text" name="contact_number" required placeholder="Enter contact number" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Email Address</label>
                        <input type="email" name="email" placeholder="Optional" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4">
                        <button type="button" @click="showAddSupplierModal = false" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Discard
                        </button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                            Add Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</x-layouts::app>