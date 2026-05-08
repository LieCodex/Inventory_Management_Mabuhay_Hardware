<div>
    <button wire:click="openEditModal" class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
        Edit
    </button>

    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Edit Supplier</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Update supplier company info, products, and image.</p>
                    </div>
                    <button type="button" wire:click="closeEditModal" class="text-zinc-500 transition hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">✕</button>
                </div>

                <form wire:submit.prevent="updateSupplier" class="grid gap-4">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Company Name</label>
                            <input type="text" wire:model.defer="company_name" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('company_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Contact Number</label>
                            <input type="text" wire:model.defer="contact_number" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('contact_number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" />
                            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Company Image (optional)</label>
                            <input type="file" wire:model="supplier_image" accept="image/*" class="mt-1 block w-full text-xs text-zinc-600 file:mr-2 file:rounded file:border-0 file:bg-emerald-50 file:px-2 file:py-1 file:text-emerald-700 hover:file:bg-emerald-100 dark:text-zinc-300 dark:file:bg-zinc-700 dark:file:text-zinc-100" />
                            @error('supplier_image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                            @if($existing_image_path && !$supplier_image)
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Current image is kept unless you upload a new one.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Supplied Products</label>
                        <select wire:model.defer="item_ids" multiple class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 outline-none ring-emerald-500 focus:ring-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 min-h-40">
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sku }})</option>
                            @endforeach
                        </select>
                        @error('item_ids') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        @error('item_ids.*') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Hold Ctrl (Windows) or Command (Mac) to select multiple products.</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="closeEditModal" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                            Cancel
                        </button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

