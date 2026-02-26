<x-layouts::app :title="__('Inventory')">
    <div class="space-y-6" x-data="{ showAddProductModal: false }">
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
                    <div class="rounded-full border border-zinc-200 p-2 text-zinc-500 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer">
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
            <h2 class="mb-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Overall Inventory</h2>
            
            <div class="grid grid-cols-2 gap-6 md:grid-cols-4 md:divide-x md:divide-zinc-200 dark:md:divide-zinc-700">
                <div class="flex flex-col space-y-2 md:pl-0">
                    <p class="text-sm font-medium text-sky-500">Categories</p>
                    <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">14</p>
                    <p class="text-xs text-zinc-500">Last 7 days</p>
                </div>
                
                <div class="flex flex-col space-y-2 md:pl-6">
                    <p class="text-sm font-medium text-amber-500">Total Products</p>
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">868</p>
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">₱25000</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-zinc-500">Last 7 days</p>
                        <p class="text-xs text-zinc-500">Revenue</p>
                    </div>
                </div>

                <div class="flex flex-col space-y-2 md:pl-6">
                    <p class="text-sm font-medium text-indigo-500">Top Selling</p>
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">5</p>
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">₱2500</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-zinc-500">Last 7 days</p>
                        <p class="text-xs text-zinc-500">Cost</p>
                    </div>
                </div>

                <div class="flex flex-col space-y-2 md:pl-6">
                    <p class="text-sm font-medium text-rose-500">Low Stocks</p>
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">12</p>
                        <p class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">2</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-zinc-500">Ordered</p>
                        <p class="text-xs text-zinc-500">Not in stock</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Products</h2>
                
                <div class="flex items-center gap-3">
                    <button @click="showAddProductModal = true" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                        Add Product
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
                            <th class="py-3 font-medium">Products</th>
                            <th class="py-3 font-medium">Buying Price</th>
                            <th class="py-3 font-medium">Quantity</th>
                            <th class="py-3 font-medium">Threshold Value</th>
                            <th class="py-3 font-medium">Expiry Date</th>
                            <th class="py-3 font-medium">Availability</th>
                        </tr>
                    </thead>
                    <tbody class="text-zinc-700 dark:text-zinc-200">
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Screw</td>
                            <td class="py-3">₱ 430</td>
                            <td class="py-3">43 pcs</td>
                            <td class="py-3">12 pcs</td>
                            <td class="py-3">11/12/22</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">In-stock</span></td>
                        </tr>
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Hammer</td>
                            <td class="py-3">₱ 257</td>
                            <td class="py-3">22 pcs</td>
                            <td class="py-3">12 pcs</td>
                            <td class="py-3">21/12/22</td>
                            <td class="py-3"><span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">Out of stock</span></td>
                        </tr>
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Pliers</td>
                            <td class="py-3">₱ 405</td>
                            <td class="py-3">36 pcs</td>
                            <td class="py-3">9 pcs</td>
                            <td class="py-3">5/12/22</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">In-stock</span></td>
                        </tr>
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Welding Machine</td>
                            <td class="py-3">₱ 502</td>
                            <td class="py-3">14 pcs</td>
                            <td class="py-3">6 pcs</td>
                            <td class="py-3">8/12/22</td>
                            <td class="py-3"><span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700 dark:bg-rose-900/40 dark:text-rose-300">Out of stock</span></td>
                        </tr>
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Gloves</td>
                            <td class="py-3">₱ 530</td>
                            <td class="py-3">5 pcs</td>
                            <td class="py-3">5 pcs</td>
                            <td class="py-3">9/1/23</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">In-stock</span></td>
                        </tr>
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-3">Phillip Head Screw...</td>
                            <td class="py-3">₱ 205</td>
                            <td class="py-3">41 pcs</td>
                            <td class="py-3">10 pcs</td>
                            <td class="py-3">11/11/22</td>
                            <td class="py-3"><span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">Low stock</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Previous
                </button>
                <span class="text-sm text-zinc-500">Page 1 of 10</span>
                <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Next
                </button>
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
                <h3 class="mb-6 text-lg font-semibold text-zinc-800 dark:text-zinc-100">New Product</h3>

                <form class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-20 w-20 items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-zinc-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="text-zinc-600 dark:text-zinc-400">Drag image here</p>
                            <p class="text-xs text-zinc-500">or</p>
                            <button type="button" class="text-emerald-600 hover:underline dark:text-emerald-400">Browse image</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Product Name</label>
                        <input type="text" placeholder="Enter product name" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Product ID</label>
                        <input type="text" placeholder="Enter product ID" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Category</label>
                        <select class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                            <option>Select product category</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Buying Price</label>
                        <input type="text" placeholder="Enter buying price" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Quantity</label>
                        <input type="text" placeholder="Enter product quantity" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Unit</label>
                        <input type="text" placeholder="Enter product unit" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Expiry Date</label>
                        <input type="text" placeholder="Enter expiry date" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Threshold Value</label>
                        <input type="text" placeholder="Enter threshold value" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-2">
                        <button type="button" @click="showAddProductModal = false" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Discard
                        </button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>