<x-layouts::app :title="$item->name . ' - Details'">
    <div class="space-y-6">
        
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
                    <button class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                        Edit
                    </button>
                    <button class="rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        Download
                    </button>
                </div>
            </div>

            <div class="mb-8 flex space-x-8 border-b border-zinc-200 dark:border-zinc-800">
                <button class="border-b-2 border-emerald-500 pb-4 text-sm font-medium text-emerald-600 dark:text-emerald-400">Overview</button>
                <button class="border-b-2 border-transparent pb-4 text-sm font-medium text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">Purchases</button>
                <button class="border-b-2 border-transparent pb-4 text-sm font-medium text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">Adjustments</button>
                <button class="border-b-2 border-transparent pb-4 text-sm font-medium text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">History</button>
            </div>

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
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">Small Items</span> </div>
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
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">Ronald Martin</span> </div>
                            <div class="grid grid-cols-2">
                                <span class="text-zinc-500">Contact Number</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">09123456789</span> </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center sm:items-end">
                    <div class="mb-8 flex h-48 w-48 items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
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
    </div>
</x-layouts::app>