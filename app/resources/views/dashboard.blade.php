<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="w-full max-w-xl">
                    <input
                        type="text"
                        placeholder="Search product, supplier, order"
                        class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm outline-none ring-emerald-500 placeholder:text-zinc-400 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800"
                    >
                </div>
                <div class="flex items-center gap-3">
                    <div class="rounded-full border border-zinc-200 p-2 text-zinc-500 dark:border-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75v-.7V9a6 6 0 1 0-12 0v.05-.001v.7a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <div class="space-y-4 xl:col-span-2">
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Sales Overview</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Sales</p>
                            <p class="mt-1 text-lg font-semibold">₱ 832</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Revenue</p>
                            <p class="mt-1 text-lg font-semibold">₱ 18,300</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Profit</p>
                            <p class="mt-1 text-lg font-semibold">₱ 868</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500">Cost</p>
                            <p class="mt-1 text-lg font-semibold">₱ 17,432</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Sales & Purchase</h2>
                        <span class="rounded-md border border-zinc-200 px-2 py-1 text-xs text-zinc-500 dark:border-zinc-700">Weekly</span>
                    </div>

                    <div class="mt-4 grid h-56 grid-cols-12 items-end gap-2 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                        <div class="h-32 rounded-t bg-sky-400"></div><div class="h-28 rounded-t bg-emerald-400"></div>
                        <div class="h-40 rounded-t bg-sky-400"></div><div class="h-[8.5rem] rounded-t bg-emerald-400"></div>
                        <div class="h-24 rounded-t bg-sky-400"></div><div class="h-[7.5rem] rounded-t bg-emerald-400"></div>
                        <div class="h-36 rounded-t bg-sky-400"></div><div class="h-[6.5rem] rounded-t bg-emerald-400"></div>
                        <div class="h-[9.75rem] rounded-t bg-sky-400"></div><div class="h-[8.25rem] rounded-t bg-emerald-400"></div>
                        <div class="h-[7.75rem] rounded-t bg-sky-400"></div><div class="h-[7.25rem] rounded-t bg-emerald-400"></div>
                    </div>
                    <div class="mt-2 flex items-center gap-4 text-xs text-zinc-500">
                        <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-sky-400"></span> Purchase</span>
                        <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-emerald-400"></span> Sales</span>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Top Selling Stock</h2>
                        <a href="#" class="text-sm text-emerald-600 hover:underline">See All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-zinc-500">
                                <tr>
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Sold Quantity</th>
                                    <th class="py-2">Remaining Quantity</th>
                                    <th class="py-2 text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-zinc-700 dark:text-zinc-200">
                                <tr class="border-t border-zinc-200 dark:border-zinc-700"><td class="py-2">Shovel</td><td>30</td><td>12</td><td class="text-right">₱ 535</td></tr>
                                <tr class="border-t border-zinc-200 dark:border-zinc-700"><td class="py-2">Pliers</td><td>21</td><td>15</td><td class="text-right">₱ 207</td></tr>
                                <tr class="border-t border-zinc-200 dark:border-zinc-700"><td class="py-2">Wrench</td><td>19</td><td>17</td><td class="text-right">₱ 105</td></tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <div class="space-y-4">
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Inventory Summary</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800"><p class="text-xs text-zinc-500">Quantity in Hand</p><p class="mt-1 text-xl font-semibold">868</p></div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800"><p class="text-xs text-zinc-500">To be received</p><p class="mt-1 text-xl font-semibold">200</p></div>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Product Summary</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800"><p class="text-xs text-zinc-500">Number of Suppliers</p><p class="mt-1 text-xl font-semibold">31</p></div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800"><p class="text-xs text-zinc-500">Number of Categories</p><p class="mt-1 text-xl font-semibold">21</p></div>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Order Summary</h2>
                    <svg viewBox="0 0 320 140" class="mt-4 h-36 w-full">
                        <polyline class="stroke-sky-400" fill="none" stroke-width="3" points="0,40 40,85 80,35 120,45 160,75 200,38 240,92 280,55 320,45" />
                        <polyline class="stroke-amber-500" fill="none" stroke-width="3" points="0,30 40,100 80,60 120,88 160,70 200,80 240,110 280,90 320,80" />
                    </svg>
                    <div class="mt-2 flex items-center gap-4 text-xs text-zinc-500">
                        <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-amber-500"></span> Ordered</span>
                        <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-sky-400"></span> Sales</span>
                    </div>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Low Quantity Stock</h2>
                        <a href="#" class="text-sm text-emerald-600 hover:underline">See All</a>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <div><p class="font-medium">Hammer</p><p class="text-xs text-zinc-500">Remaining Quantity: 10 pcs</p></div>
                            <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">Low</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <div><p class="font-medium">Screws</p><p class="text-xs text-zinc-500">Remaining Quantity: 15 pcs</p></div>
                            <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">Low</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <div><p class="font-medium">Rebar</p><p class="text-xs text-zinc-500">Remaining Quantity: 15 pcs</p></div>
                            <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">Low</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-layouts::app>
