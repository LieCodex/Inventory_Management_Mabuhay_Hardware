<x-layouts::app :title="__('Suppliers')">
    <div class="space-y-6" x-data="{ showAddSupplierModal: false }">
        
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <livewire:dashboard-search />
                <div class="flex items-center gap-3">

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
                    <a href="{{ route('inventory_manager.suppliers.export') }}" class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        Download all
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="py-3 font-medium">Supplier Company</th>
                            <th class="py-3 font-medium">Products</th>
                            <th class="py-3 font-medium">Contact Number</th>
                            <th class="py-3 font-medium">Email</th>
                            <th class="py-3 text-center font-medium">On the way</th>
                            <th class="py-3 text-right font-medium leading-tight">Expected Date<br>of Arrival</th>
                        </tr>
                    </thead>
                        <tbody class="text-zinc-700 dark:text-zinc-200">
                            @forelse($suppliers as $supplier)
                                <tr 
                                    onclick="window.location='{{ route('inventory_manager.suppliers.show', $supplier->primary_supplier_id) }}'" 
                                    class="border-t border-zinc-100 cursor-pointer transition-colors hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50"
                                >
                                    <td class="py-4 font-medium">{{ $supplier->company_name }}</td>
                                    <td class="py-4">
                                        @if(!empty($supplier->item_names))
                                            {{ implode(', ', array_slice($supplier->item_names, 0, 3)) }}
                                            @if(count($supplier->item_names) > 3)
                                                <span class="text-zinc-500"> +{{ count($supplier->item_names) - 3 }} more</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
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

                <form action="{{ route('inventory_manager.suppliers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Company Name</label>
                        <input type="text" name="company_name" required placeholder="Enter company name" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Company Image</label>
                        <div class="col-span-2">
                            <input type="file" name="supplier_image" accept="image/*" class="block w-full text-sm text-zinc-600 file:mr-2 file:rounded file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:text-emerald-700 hover:file:bg-emerald-100 dark:text-zinc-300 dark:file:bg-zinc-700 dark:file:text-zinc-100" />
                            @error('supplier_image') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Supplied Products</label>
                            <div class="col-span-2">
                            <select name="item_ids[]" multiple required class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 min-h-32">
                                
                                @forelse($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sku }})</option>
                                @empty
                                    <option value="" disabled>⚠️ No products found! Add items in Inventory first.</option>
                                @endforelse
                            </select>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Hold Ctrl (Windows) or Command (Mac) to select multiple products.</p>
                            </div>
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