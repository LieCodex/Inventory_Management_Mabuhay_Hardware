<x-layouts::app :title="__('Cashier Dashboard')">
    <div class="space-y-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h1 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">Cashier Dashboard</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Welcome, {{ auth()->user()->name }}.
            </p>
        </div>
    </div>
</x-layouts::app>
