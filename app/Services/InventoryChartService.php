<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryChartService
{
    public function getWeeklySalesPurchases()
    {
        $startDate = Carbon::now()->startOfDay()->subDays(6);

        $salesByDay = Transaction::where('transaction_date', '>=', $startDate)
            ->selectRaw('DATE(transaction_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $purchasesByDay = DB::table('logistic_items')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(quantity * unit_cost) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        return collect(range(0, 6))->map(function ($offset) use ($startDate, $salesByDay, $purchasesByDay) {
            $date = $startDate->copy()->addDays($offset);
            $key = $date->toDateString();
            return [
                'label' => $date->format('D'),
                'sales' => (float) ($salesByDay->get($key, 0)),
                'purchases' => (float) ($purchasesByDay->get($key, 0)),
            ];
        });
    }
}