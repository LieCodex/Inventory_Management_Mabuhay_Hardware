<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryChartService
{
    public function getWeeklySalesPurchases($date = null)
    {
        if (!$date) {
            $date = Carbon::now();
        }

        $startDate = $date->copy()->startOfWeek()->startOfDay();
        $endDate = $date->copy()->endOfWeek()->endOfDay();

        $salesByDay = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('DATE(transaction_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $purchasesByDay = DB::table('logistic_items')
            ->whereBetween('created_at', [$startDate, $endDate])
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

    public function getMonthlySalesPurchases($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        $salesByDay = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('DATE(transaction_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $purchasesByDay = DB::table('logistic_items')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(quantity * unit_cost) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $daysInMonth = $endDate->day;

        return collect(range(1, $daysInMonth))->map(function ($day) use ($year, $month, $salesByDay, $purchasesByDay) {
            $date = Carbon::createFromDate($year, $month, $day);
            $key = $date->toDateString();
            return [
                'label' => $date->format('d'),
                'sales' => (float) ($salesByDay->get($key, 0)),
                'purchases' => (float) ($purchasesByDay->get($key, 0)),
            ];
        });
    }

    public function getYearlySalesPurchases($year)
    {
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfYear()->endOfDay();

        $salesByMonth = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('MONTH(transaction_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $purchasesByMonth = DB::table('logistic_items')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('MONTH(created_at) as month, SUM(quantity * unit_cost) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return collect(range(1, 12))->map(function ($month) use ($year, $salesByMonth, $purchasesByMonth) {
            $date = Carbon::createFromDate($year, $month, 1);
            return [
                'label' => $date->format('M'),
                'sales' => (float) ($salesByMonth->get($month, 0)),
                'purchases' => (float) ($purchasesByMonth->get($month, 0)),
            ];
        });
    }
}