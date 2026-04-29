<div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
    <div class="flex flex-col gap-4">
        <!-- Header with title and period controls -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Sales & Purchase</h2>
            <span class="rounded-md border border-zinc-200 px-2 py-1 text-xs text-zinc-500 dark:border-zinc-700 capitalize">{{ $periodLabel }}</span>
        </div>

        <!-- Period Toggle and Date Controls -->
        <div class="flex flex-wrap gap-3 items-center justify-between border-b border-zinc-200 dark:border-zinc-700 pb-4">
            <!-- Period Selection Buttons -->
            <div class="flex gap-2">
                <button 
                    wire:click="setPeriod('weekly')" 
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $period === 'weekly' ? 'bg-emerald-500 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700' }}">
                    Weekly
                </button>
                <button 
                    wire:click="setPeriod('monthly')" 
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $period === 'monthly' ? 'bg-emerald-500 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700' }}">
                    Monthly
                </button>
                <button 
                    wire:click="setPeriod('yearly')" 
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $period === 'yearly' ? 'bg-emerald-500 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700' }}">
                    Yearly
                </button>
            </div>

            <!-- Date Navigation -->
            <div class="flex items-center gap-2">
                <button 
                    wire:click="previousPeriod"
                    class="rounded-lg border border-zinc-200 p-1.5 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <input 
                    type="date" 
                    wire:model.live="selectedDate"
                    class="rounded-lg border border-zinc-200 px-3 py-1.5 text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">

                <button 
                    wire:click="nextPeriod"
                    class="rounded-lg border border-zinc-200 p-1.5 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>

     
        <div class="mt-4 h-80 w-full">
            <canvas id="salesChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

{{-- 1. Use @assets to ensure Chart.js only loads once across your app --}}
@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

{{-- 2. Use @script to automatically scope variables and run on component mount --}}
@script
<script>
    let chartInstance = null;

    function renderChart(data) {
        try {
            if (!data || !Array.isArray(data) || data.length === 0) return;

            const canvas = document.getElementById('salesChart');
            if (!canvas) return;

            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }

            setTimeout(() => {
                const ctx = canvas.getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [
                            {
                                label: 'Sales',
                                data: data.map(d => d.sales),
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 4,
                                pointBackgroundColor: '#10b981'
                            },
                            {
                                label: 'Purchase',
                                data: data.map(d => d.purchases),
                                borderColor: '#38bdf8',
                                backgroundColor: 'rgba(56, 189, 248, 0.1)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 4,
                                pointBackgroundColor: '#38bdf8'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: true, position: 'top' }
                        },
                        scales: {
                            x: { display: true, grid: { display: false } },
                            y: { display: true, grid: { color: '#e4e4e7' } }
                        }
                    }
                });
            }, 50);
        } catch (error) {
            console.error('Error in renderChart:', error);
        }
    }

    // 3. Instead of DOMContentLoaded, grab the initial data directly from $wire on mount
    renderChart($wire.chartData);

    // 4. Listen for the Livewire event
    $wire.on('chart-updated', (event) => {
        // Livewire 3 passes dispatched parameters inside an array
        let payload = event[0] || event;
        if (payload && payload.chartData) {
            renderChart(payload.chartData);
        }
    });
</script>
@endscript