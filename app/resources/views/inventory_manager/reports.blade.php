<x-layouts::app :title="__('Reports')">
    <div class="space-y-6">
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

        <div class="grid gap-6 lg:grid-cols-3">
            <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900 lg:col-span-2">
                <h2 class="mb-6 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Overview</h2>
                
                <div class="grid grid-cols-3 gap-6 border-b border-zinc-200 pb-6 dark:border-zinc-800">
                    <div class="space-y-1">
                        <p class="text-xl font-semibold text-emerald-500 dark:text-emerald-500">₱{{ number_format($profit, 2) }}</p>
                        <p class="text-sm text-emerald-500">Total Profit</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xl font-semibold text-amber-500">₱{{ number_format($revenue, 2) }}</p>
                        <p class="text-sm text-amber-500/80">Revenue</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xl font-semibold text-sky-500">₱{{ number_format($cost, 2) }}</p>
                        <p class="text-sm text-sky-500/80">Cost of Goods</p> 
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-4 gap-6">
                    <div class="space-y-1">
                        <p class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱{{ number_format($netPurchaseValue, 2) }}</p>
                        <p class="text-xs text-zinc-500">Net purchase value</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱{{ number_format($netSalesValue, 2) }}</p>
                        <p class="text-xs text-zinc-500">Net sales value</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱{{ number_format($momProfit, 2) }}</p>
                        <p class="text-xs text-zinc-500">MoM Profit</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">₱{{ number_format($yoyProfit, 2) }}</p>
                        <p class="text-xs text-zinc-500">YoY Profit</p>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Best selling category</h2>
                    <a href="#" class="text-sm font-medium text-sky-500 hover:text-sky-400">See All</a>
                </div>

                <table class="w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="pb-3 font-medium">Category</th>
                            <th class="pb-3 font-medium">Turn Over</th>
                            <th class="pb-3 text-right font-medium">Trend</th>
                        </tr>
                    </thead>
                    <tbody class="text-zinc-700 dark:text-zinc-200">
                        @forelse($bestCategories as $category)
                            <tr class="border-t border-zinc-100 dark:border-zinc-800">
                                <td class="py-3">{{ $category->category }}</td>
                                <td class="py-3">₱{{ number_format($category->turnover, 2) }}</td>
                                <td class="py-3 text-right text-emerald-500">--</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-zinc-500">No sales data yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Best selling product</h2>
                <a href="{{ route('inventory.index') }}" class="text-sm font-medium text-sky-500 hover:text-sky-400">See All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-zinc-500">
                        <tr>
                            <th class="pb-3 font-medium">Product</th>
                            <th class="pb-3 font-medium">Product ID</th>
                            <th class="pb-3 font-medium">Category</th>
                            <th class="pb-3 font-medium">Remaining Quantity</th>
                            <th class="pb-3 font-medium">Turn Over</th>
                            <th class="pb-3 text-right font-medium">Trend</th>
                        </tr>
                    </thead>
                    <tbody class="text-zinc-700 dark:text-zinc-200">
                        @forelse($bestProducts as $product)
                            <tr class="border-t border-zinc-100 dark:border-zinc-800">
                                <td class="py-4 font-medium">{{ $product->item->name ?? 'Unknown' }}</td>
                                <td class="py-4">{{ $product->item->sku ?? 'N/A' }}</td>
                                <td class="py-4">{{ $product->item->category ?? 'N/A' }}</td>
                                <td class="py-4">{{ $product->item->quantity_on_hand ?? 0 }} {{ $product->item->unit_of_measure ?? '' }}</td>
                                <td class="py-4">₱{{ number_format($product->turnover, 2) }}</td>
                                <td class="py-4 text-right text-emerald-500">--</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-zinc-500">No sales data available yet to determine best sellers.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </div>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Profit & Revenue</h2>
                <button class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Weekly
                </button>
            </div>

            <div class="relative h-64 w-full">
                <div class="absolute bottom-6 left-0 top-0 flex flex-col justify-between text-xs text-zinc-500">
                    <span>80,000</span>
                    <span>60,000</span>
                    <span>40,000</span>
                    <span>20,000</span>
                </div>
                
                <div class="absolute bottom-6 left-12 right-0 top-2 flex flex-col justify-between">
                    <div class="w-full border-t border-zinc-100 dark:border-zinc-800"></div>
                    <div class="w-full border-t border-zinc-100 dark:border-zinc-800"></div>
                    <div class="w-full border-t border-zinc-100 dark:border-zinc-800"></div>
                    <div class="w-full border-t border-zinc-100 dark:border-zinc-800"></div>
                </div>

                <div class="absolute bottom-6 left-12 right-0 top-0">
                    <svg viewBox="0 0 800 200" class="h-full w-full" preserveAspectRatio="none">
                        <path d="M0,150 C50,140 100,100 150,110 C200,120 250,160 300,150 C350,140 400,100 450,80 C500,60 550,50 600,60 C650,70 700,120 750,140 C800,160 800,160 800,160" fill="none" class="stroke-sky-500" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0,100 C50,90 100,120 150,130 C200,140 250,120 300,110 C350,100 400,60 450,40 C500,20 550,60 600,40 C650,20 700,60 750,90 C800,110 800,110 800,110" fill="none" class="stroke-amber-400 opacity-60" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        
                        <circle cx="450" cy="80" r="4" class="fill-sky-500" />
                        <line x1="450" y1="80" x2="450" y2="200" class="stroke-sky-500 stroke-1" stroke-dasharray="4" />
                    </svg>

                    <div class="absolute left-[56%] top-4 -translate-x-1/2 rounded-lg bg-white p-3 shadow-lg ring-1 ring-zinc-200 dark:bg-zinc-800 dark:ring-zinc-700">
                        <p class="text-[10px] text-zinc-500 uppercase tracking-wider mb-1">Dec</p>
                        <p class="text-sm font-bold text-zinc-800 dark:text-zinc-100">₱20,342,123</p>
                        <p class="text-[10px] text-zinc-400 mt-1">Revenue</p>
                    </div>
                </div>

                <div class="absolute bottom-0 left-12 right-0 flex justify-between text-xs text-zinc-500 pr-4">
                    <span>Sep</span>
                    <span>Oct</span>
                    <span>Nov</span>
                    <span>Dec</span>
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-center gap-6 text-xs text-zinc-500">
                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-sky-500"></span> Revenue
                </span>
                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span> Profit
                </span>
            </div>
        </section>

    </div>
</x-layouts::app>