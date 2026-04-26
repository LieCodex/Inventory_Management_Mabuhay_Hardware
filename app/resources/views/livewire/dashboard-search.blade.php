<div class="relative w-full max-w-xl">
    <div class="relative">
        <input 
            wire:model.live="searchQuery" 
            type="text" 
            placeholder="Search item, supplier, deliveries"
            @click="$dispatch('show-results')"
            class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm outline-none ring-emerald-500 placeholder:text-zinc-400 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
        >
        @if($showResults && count($searchResults) > 0)
            <div class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
                @forelse($searchResults as $result)
                    <a 
                        href="{{ $result['route'] }}"
                        class="flex items-center justify-between px-4 py-3 border-b border-zinc-100 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors last:border-b-0"
                    >
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                @if($result['type'] === 'item')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 dark:bg-blue-900/40 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.625c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                        Item
                                    </span>
                                @elseif($result['type'] === 'supplier')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:text-emerald-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7.5h3m-3 4h3M7 7.5h3M7 11.5h3M4 7.5v10a1.5 1.5 0 001.5 1.5h13a1.5 1.5 0 001.5-1.5v-10" />
                                        </svg>
                                        Supplier
                                    </span>
                                @elseif($result['type'] === 'delivery')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 dark:bg-amber-900/40 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m0 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m0 0H21.375a1.125 1.125 0 001.125-1.125V14.25M9 6.75h6m.75 3h-1.5m0 0h-1.5m0 0h-1.5" />
                                        </svg>
                                        Delivery
                                    </span>
                                @endif
                                <span class="font-medium text-zinc-800 dark:text-zinc-100 truncate">{{ $result['name'] }}</span>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 truncate">{{ $result['subtitle'] }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-zinc-400 flex-shrink-0 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                        </svg>
                    </a>
                @empty
                    @if($searchQuery)
                        <div class="px-4 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            <p>No results found for "{{ $searchQuery }}"</p>
                        </div>
                    @endif
                @endforelse
            </div>
        @endif
    </div>

    @if($showResults && $searchQuery)
        <div 
            class="fixed inset-0 z-40" 
            @click="$wire.closeResults()"
        ></div>
    @endif
</div>
