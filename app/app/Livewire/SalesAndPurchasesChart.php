<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\InventoryChartService;
use Carbon\Carbon;

class SalesAndPurchasesChart extends Component
{
    public $period = 'monthly'; // weekly, monthly, yearly
    public $selectedDate;
    public $periodLabel = 'This Month';

    public $chartData = [];

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->updatePeriodLabel();
        $this->updateChartData();
    }

    public function updateChartData()
    {
        $chartService = new InventoryChartService();
        $selectedDate = Carbon::parse($this->selectedDate);

        $this->chartData = match ($this->period) {
            'weekly' => $chartService->getWeeklySalesPurchases($selectedDate),
            'monthly' => $chartService->getMonthlySalesPurchases($selectedDate->year, $selectedDate->month),
            'yearly' => $chartService->getYearlySalesPurchases($selectedDate->year),
        };

        \Log::info('Chart data updated for period: ' . $this->period . ', count: ' . count($this->chartData));
    }

public function setPeriod($newPeriod)
{
    $this->period = $newPeriod;
    $this->updatePeriodLabel();
    $this->updateChartData();
    $this->dispatch('chart-updated', chartData: collect($this->chartData)->values()->toArray());
}

public function updatedSelectedDate()
{
    $this->updatePeriodLabel();
    $this->updateChartData();
    $this->dispatch('chart-updated', chartData: collect($this->chartData)->values()->toArray());
}

    public function updatePeriodLabel()
    {
        $selectedDate = Carbon::parse($this->selectedDate);

        $this->periodLabel = match ($this->period) {
            'weekly' => 'Week of ' . $selectedDate->startOfWeek()->format('M d, Y'),
            'monthly' => $selectedDate->format('F Y'),
            'yearly' => $selectedDate->year . '',
        };
    }

   public function previousPeriod()
{
    $date = Carbon::parse($this->selectedDate);
    $date = match ($this->period) {
        'weekly'  => $date->subWeeks(1),
        'monthly' => $date->subMonths(1),
        'yearly'  => $date->subYears(1),
    };
    $this->selectedDate = $date->format('Y-m-d');
    $this->updatePeriodLabel();          // ← was missing
    $this->updateChartData();
    $this->dispatch('chart-updated', chartData: collect($this->chartData)->values()->toArray());
}
public function nextPeriod()
{
    $date = Carbon::parse($this->selectedDate);
    $date = match ($this->period) {
        'weekly'  => $date->addWeeks(1),
        'monthly' => $date->addMonths(1),
        'yearly'  => $date->addYears(1),
    };
    $this->selectedDate = $date->format('Y-m-d');
    $this->updatePeriodLabel();          // ← was missing
    $this->updateChartData();
    $this->dispatch('chart-updated', chartData: collect($this->chartData)->values()->toArray());
}

    public function render()
    {
        return view('livewire.sales-and-purchases-chart', [
            'chartData' => $this->chartData,
        ]);
    }
}
