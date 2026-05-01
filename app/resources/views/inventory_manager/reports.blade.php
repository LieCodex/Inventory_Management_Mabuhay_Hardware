<x-layouts::app :title="__('Reports')">
    <div class="space-y-6">
        
        {{-- Top Header Section --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <livewire:dashboard-search />
                <div class="flex items-center gap-3">

                </div>
            </div>
        </div>

        {{-- Overview Cards --}}
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

            {{-- Categories Table --}}
            <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Best selling category</h2>
                    <a href="{{ route('inventory_manager.inventory') }}" class="text-sm font-medium text-sky-500 hover:text-sky-400">See All</a>
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

        {{-- Profit & Revenue Chart --}}
        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Profit & Revenue</h2>
            </div>

            <div class="relative h-64 w-full">
                <canvas id="profitRevenueChart"></canvas>
            </div>
        </section>

        {{-- Products Table --}}
        <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Best selling product</h2>
                <a href="{{ route('inventory_manager.inventory') }}" class="text-sm font-medium text-sky-500 hover:text-sky-400">See All</a>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-zinc-500">No sales data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Listen for when the page is fully loaded via Livewire
        document.addEventListener('livewire:navigated', () => {
            const canvas = document.getElementById('profitRevenueChart');
            if (!canvas) return; 

            const ctx = canvas.getContext('2d');
            
            // 2. Check the global window object. If a chart exists, destroy it.
            if (window.profitRevenueChartInstance) {
                window.profitRevenueChartInstance.destroy();
            }

            const currencyFormatter = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 0,
            });

            // 3. Assign the new chart to the global window object
            window.profitRevenueChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            type: 'line',
                            label: 'Profit',
                            data: @json($chartProfit),
                            borderColor: '#10b981',
                            backgroundColor: '#10b981',
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            order: 1
                        },
                        {
                            type: 'bar',
                            label: 'Revenue',
                            data: @json($chartRevenue),
                            backgroundColor: 'rgba(14, 165, 233, 0.15)',
                            borderColor: '#0ea5e9',
                            borderWidth: 1,
                            borderRadius: 4,
                            order: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { usePointStyle: true, boxWidth: 8 }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += currencyFormatter.format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { 
                                color: '#e4e4e7',
                                drawBorder: false 
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return '₱' + (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return '₱' + (value / 1000).toFixed(0) + 'k';
                                    return '₱' + value;
                                }
                            }
                        },
                        x: { 
                            grid: { display: false } 
                        }
                    }
                }
            });
        });

        // 4. Memory cleanup: Destroy the chart right BEFORE you leave the page
        document.addEventListener('livewire:navigating', () => {
            if (window.profitRevenueChartInstance) {
                window.profitRevenueChartInstance.destroy();
                window.profitRevenueChartInstance = null; // Clear it out
            }
        });
    </script>
</x-layouts::app>