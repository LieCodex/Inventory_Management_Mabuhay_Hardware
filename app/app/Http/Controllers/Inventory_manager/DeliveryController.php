<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        // Fetch all deliveries with their associated items and logs
        $deliveries = DB::table('logistic_items')
            ->join('logistic_logs', 'logistic_items.logs_id', '=', 'logistic_logs.id')
            ->join('items', 'logistic_items.item_id', '=', 'items.id')
            ->select(
                'logistic_items.id',
                'logistic_items.item_id',
                'items.name as item_name',
                'items.sku',
                'logistic_items.quantity',
                'logistic_items.unit_cost',
                'logistic_items.expiry_date',
                'logistic_items.supplier',
                'logistic_logs.date as delivery_date',
                'logistic_logs.logistic_company',
                'logistic_logs.id as log_id'
            )
            ->orderBy('logistic_logs.date', 'desc')
            ->paginate(15);

        return view('inventory_manager.deliveries', compact('deliveries'));
    }

    public function show($logId)
    {
        // Show details of a specific delivery log
        $delivery = DB::table('logistic_logs')
            ->where('id', $logId)
            ->first();

        if (!$delivery) {
            return redirect()->route('inventory_manager.deliveries')->with('error', 'Delivery not found');
        }

        // Get all items in this delivery
        $items = DB::table('logistic_items')
            ->join('items', 'logistic_items.item_id', '=', 'items.id')
            ->where('logistic_items.logs_id', $logId)
            ->select(
                'logistic_items.id',
                'logistic_items.item_id',
                'items.name as item_name',
                'items.sku',
                'logistic_items.quantity',
                'logistic_items.unit_cost',
                'logistic_items.expiry_date'
            )
            ->get();

        return view('inventory_manager.delivery_details', compact('delivery', 'items'));
    }
}
