<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\SupplierInfo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Inventory_ManagerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Simple dummy data for the catalog
        $itemsData = [
            ['name' => 'Portland Cement', 'sku' => 'CEM-001', 'category' => 'Materials', 'uom' => 'Bags', 'price' => 250, 'qty' => 150, 'threshold' => 50],
            ['name' => 'Power Drill', 'sku' => 'DRL-001', 'category' => 'Power Tools', 'uom' => 'pcs', 'price' => 3500, 'qty' => 15, 'threshold' => 5],
            ['name' => 'Assorted Nails', 'sku' => 'NAL-001', 'category' => 'Small Items', 'uom' => 'Boxes', 'price' => 150, 'qty' => 8, 'threshold' => 10], 
            ['name' => 'Marine Plywood', 'sku' => 'PLY-001', 'category' => 'Materials', 'uom' => 'Sheets', 'price' => 1200, 'qty' => 0, 'threshold' => 20], 
            ['name' => 'Hammer', 'sku' => 'HAM-001', 'category' => 'Hand Tools', 'uom' => 'pcs', 'price' => 450, 'qty' => 30, 'threshold' => 10],
        ];

        foreach ($itemsData as $data) {
            
            // updateOrCreate checks if the SKU exists first. No more duplicate crashes!
            $item = Item::updateOrCreate(
                ['sku' => $data['sku']], 
                [
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'unit_of_measure' => $data['uom'],
                    'price_per_unit' => $data['price'],
                    'quantity_on_hand' => $data['qty'],
                    'low_stock_threshold' => $data['threshold'],
                ]
            );

            // Create or update the supplier for this item
            $supplier = SupplierInfo::updateOrCreate(
                ['item_id' => $item->id],
                [
                    'company_name' => explode(' ', $item->name)[0] . ' Builders Supply',
                    'contact_number' => '09' . rand(100000000, 999999999),
                    'email' => 'contact@' . strtolower(explode(' ', $item->name)[0]) . 'supply.com',
                    'quantity_on_the_way' => rand(0, 1) ? rand(50, 200) : 0,
                    'eta' => Carbon::now()->addDays(rand(2, 14)),
                ]
            );

            if (DB::table('inventory_batches')->where('item_id', $item->id)->doesntExist()) {
                if ($item->quantity_on_hand > 0) {
                    DB::table('inventory_batches')->insert([
                        'item_id' => $item->id,
                        'quantity_remaining' => $item->quantity_on_hand,
                        'price' => $item->price_per_unit * 0.65, // Simulated buying price
                        'expiry_date' => $item->category === 'Materials' ? Carbon::now()->addMonths(12) : null,
                        'received_at' => Carbon::now()->subDays(2),
                        'created_at' => Carbon::now()->subDays(2),
                        'updated_at' => Carbon::now()->subDays(2),
                    ]);
                }

                DB::table('inventory_logs')->insert([
                    'item_id' => $item->id,
                    'type' => 'addition',
                    'quantity_change' => $item->quantity_on_hand,
                    'remarks' => 'Initial warehouse stocking',
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now()->subDays(2),
                ]);
            }
        }

        if (DB::table('logistic_logs')->count() === 0) {
            $logId = DB::table('logistic_logs')->insertGetId([
                'date' => Carbon::now(),
                'logistic_company' => 'Mabuhay Freight Co.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $incomingSuppliers = SupplierInfo::where('quantity_on_the_way', '>', 0)->get();
            foreach ($incomingSuppliers as $sup) {
                $item = Item::find($sup->item_id);
                DB::table('logistic_items')->insert([
                    'logs_id' => $logId,
                    'item_id' => $sup->item_id,
                    'quantity' => $sup->quantity_on_the_way,
                    'unit_cost' => $item->price_per_unit * 0.65,
                    'expiry_date' => null,
                    'supplier' => $sup->company_name, 
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}