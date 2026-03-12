<div class="space-y-4">
    <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="w-full max-w-xl">
                <flux:input
                    wire:model.debounce.300ms="search"
                    wire:keydown.enter="addByBarcode"
                    :label="__('Scan / Search product')"
                    placeholder="Search by barcode, SKU, or name"
                    class="w-full"
                    autoupdate="false"
                />
            </div>
            <div class="flex items-center gap-3">
                <div class="rounded-full border border-zinc-200 p-2 text-zinc-500 dark:border-zinc-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75v-.7V9a6 6 0 1 0-12 0v.05-.001v.7a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">Recently Searched</p>
                <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                    {{ $search ?: '-' }}
                </p>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">Grand Total</p>
                <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($this->total, 2) }}</p>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">Items in Basket</p>
                <p class="mt-1 text-xl font-semibold text-zinc-800 dark:text-zinc-100">{{ count($cart) }}</p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($this->searchResults->isNotEmpty() ? $this->searchResults : $this->featuredItems as $item)
                        <button wire:click.prevent="addItem({{ $item->id }})" wire:key="item-{{ $item->id }}" class="group rounded-xl border border-zinc-200 bg-white p-4 text-left shadow-sm transition hover:border-emerald-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $item->name }}</h3>
                                <span class="text-xs text-zinc-500">PI: {{ $item->sku ?? '—' }}</span>
                            </div>
                            <div class="mt-4 flex items-end justify-between">
                                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100">₱ {{ number_format($item->price_per_unit ?? 0, 2) }}</div>
                                <div class="text-xs text-zinc-500">Stock: {{ $item->quantity_on_hand }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Current Order</h2>
                    <span class="text-xs text-zinc-500">Line Total</span>
                </div>

                <div class="mt-4 max-h-96 space-y-2 overflow-y-auto pr-1">
                    @if(empty($cart))
                        <p class="py-10 text-center text-sm text-zinc-500">Add items to begin the order.</p>
                    @else
                        @foreach($cart as $itemId => $item)
                            <div class="grid grid-cols-[1fr_auto] gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-700 dark:bg-zinc-800">
                                <div>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $item['name'] }}</p>
                                    <p class="text-xs text-zinc-500">₱ {{ number_format($item['price'], 2) }} / {{ $item['uom'] }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-1">
                                        <flux:button size="xs" variant="outline" wire:click="updateQuantity({{ $item['id'] }}, {{ max(1, $item['quantity'] - 1) }})">-</flux:button>
                                        <span class="w-10 text-center text-sm font-semibold">{{ $item['quantity'] }}</span>
                                        <flux:button size="xs" variant="outline" wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</flux:button>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                                        <span>₱ {{ number_format($item['subtotal'], 2) }}</span>
                                        <button wire:click.prevent="removeItem({{ $item['id'] }})" class="text-rose-600 hover:text-rose-800 dark:text-rose-300 dark:hover:text-rose-100">✕</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-4 space-y-2">
                    @if($error)
                        <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700 dark:border-rose-700/50 dark:bg-rose-900/40 dark:text-rose-200">
                            {{ $error }}
                        </div>
                    @endif
                    @if($message)
                        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 dark:border-emerald-700/50 dark:bg-emerald-900/40 dark:text-emerald-200">
                            {{ $message }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-zinc-500">
                            <div>Subtotal: <span class="font-semibold text-zinc-700 dark:text-zinc-100">₱ {{ number_format($this->total, 2) }}</span></div>
                        </div>

                        <div class="flex flex-col gap-2 sm:flex-row">
                            @if(empty($cart))
                                <flux:button size="sm" variant="outline" disabled>
                                    Check Out
                                </flux:button>
                            @else
                                <flux:button size="sm" variant="outline" wire:click="checkout">
                                    Check Out
                                </flux:button>
                            @endif

                            <flux:button size="sm" variant="danger" wire:click.prevent="cart = []">
                                Cancel Order
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
