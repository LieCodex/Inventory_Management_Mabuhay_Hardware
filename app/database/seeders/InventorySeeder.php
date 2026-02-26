<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Screw', 
                'sku' => 'SCR-001', 
                'unit_of_measure' => 'pcs', 
                'price_per_unit' => 430, 
                'quantity_on_hand' => 43, 
                'low_stock_threshold' => 12
            ],
            [
                'name' => 'Hammer', 
                'sku' => 'HAM-001', 
                'unit_of_measure' => 'pcs', 
                'price_per_unit' => 257, 
                'quantity_on_hand' => 22, 
                'low_stock_threshold' => 12
            ],
            [
                'name' => 'Pliers', 
                'sku' => 'PLI-001', 
                'unit_of_measure' => 'pcs', 
                'price_per_unit' => 405, 
                'quantity_on_hand' => 36, 
                'low_stock_threshold' => 9
            ],
            [
                'name' => 'Welding Machine', 
                'sku' => 'WEL-001', 
                'unit_of_measure' => 'pcs', 
                'price_per_unit' => 502, 
                'quantity_on_hand' => 14, 
                'low_stock_threshold' => 6
            ]
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}