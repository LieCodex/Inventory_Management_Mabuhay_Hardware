<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Item;
use App\Models\InventoryBatch;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get some items to sell
        $items = Item::all();
        
        if ($items->isEmpty()) {
            $this->command->error('No items found! Run Inventory_ManagerSeeder first.');
            return;
        }

        // Create 10 dummy transactions
        for ($i = 0; $i < 10; $i++) {
            $date = Carbon::now()->subDays(rand(0, 30));
            
            // Create Transaction
            $transaction = Transaction::create([
                'total_amount' => 0, // We calculate this after items
                'transaction_date' => $date,
            ]);

            $total = 0;
            
            // Add 2-3 items to each transaction
            foreach ($items->random(rand(1, 3)) as $item) {
                $batch = InventoryBatch::where('item_id', $item->id)->first();
                $qty = rand(1, 5);
                $price = $item->price_per_unit;
                $subtotal = $qty * $price;
                
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'item_id' => $item->id,
                    'batch_id' => $batch ? $batch->id : null,
                    'quantity' => $qty,
                    'price_at_sale'  => $price,
                    'subtotal' => $subtotal,
                ]);
                
                $total += $subtotal;
            }
            
            $transaction->update(['total_amount' => $total]);
        }
    }
}   