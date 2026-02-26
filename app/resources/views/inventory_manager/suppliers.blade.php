<x-layouts::app :title="__('Suppliers')">
    <div class="space-y-6" x-data="{ showAddSupplierModal: false }">
        
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
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Richard Martin</td>
                            <td class="py-4">Screws</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">richard@gmail.com</td>
                            <td class="py-4 text-center">100</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Tom Homan</td>
                            <td class="py-4">Nails</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">tomhoman@gmail.com</td>
                            <td class="py-4 text-center">-</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Veandir</td>
                            <td class="py-4">Bolts</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">veandier@gmail.com</td>
                            <td class="py-4 text-center">-</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Charin</td>
                            <td class="py-4">Anchors</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">charin@gmail.com</td>
                            <td class="py-4 text-center">12</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Hoffman</td>
                            <td class="py-4">Hinges</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">hoffman@gmail.com</td>
                            <td class="py-4 text-center">-</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Fainden Juke</td>
                            <td class="py-4">Door handles</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">fainden@gmail.com</td>
                            <td class="py-4 text-center">9</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Martin</td>
                            <td class="py-4">Padlocks & hasps</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">martin@gmail.com</td>
                            <td class="py-4 text-center">-</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Joe Nike</td>
                            <td class="py-4">Brackets</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">joenike@gmail.com</td>
                            <td class="py-4 text-center">-</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                        <tr class="border-t border-zinc-100 dark:border-zinc-800">
                            <td class="py-4">Dender Luke</td>
                            <td class="py-4">Hammers</td>
                            <td class="py-4">09123456789</td>
                            <td class="py-4">dender@gmail.com</td>
                            <td class="py-4 text-center">7</td>
                            <td class="py-4 text-right">10/12/25</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800">
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

                <form class="space-y-5">
                    <div class="mb-6 flex items-center justify-center gap-4 sm:justify-start sm:pl-[33%]">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full border-2 border-dashed border-zinc-300 bg-zinc-50 text-zinc-400 dark:border-zinc-600 dark:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="text-zinc-600 dark:text-zinc-400">Drag image here</p>
                            <p class="text-xs text-zinc-500">or</p>
                            <button type="button" class="text-emerald-600 hover:underline dark:text-emerald-400">Browse image</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Supplier Name</label>
                        <input type="text" placeholder="Enter supplier name" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Item</label>
                        <input type="text" placeholder="Enter item" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Category</label>
                        <select class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                            <option>Select item category</option>
                            <option>Materials</option>
                            <option>Power Tools</option>
                            <option>Small Items</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Buying Price</label>
                        <input type="text" placeholder="Enter buying price" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm text-zinc-600 dark:text-zinc-400">Contact Number</label>
                        <input type="text" placeholder="Enter supplier contact number" class="col-span-2 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>

                    <div class="grid grid-cols-3 items-start gap-4">
                        <label class="pt-2 text-sm text-zinc-600 dark:text-zinc-400">Type</label>
                        <div class="col-span-2 flex flex-col gap-3 sm:flex-row">
                            <label class="flex cursor-pointer items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-100 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 has-[:checked]:text-emerald-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:has-[:checked]:border-emerald-500 dark:has-[:checked]:bg-emerald-900/20 dark:has-[:checked]:text-emerald-400">
                                <input type="radio" name="return_type" value="not_taking" class="peer hidden" checked>
                                <span>Not taking return</span>
                            </label>
                            
                            <label class="flex cursor-pointer items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm text-zinc-600 transition-colors hover:bg-zinc-100 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 has-[:checked]:text-emerald-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:has-[:checked]:border-emerald-500 dark:has-[:checked]:bg-emerald-900/20 dark:has-[:checked]:text-emerald-400">
                                <input type="radio" name="return_type" value="taking" class="peer hidden">
                                <span>Taking return</span>
                            </label>
                        </div>
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