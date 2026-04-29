<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
            'sku', 'name', 'category', 'description', 'unit_of_measure', 
            'pricing_type', 'price_per_unit', 'barcode', 
            'quantity_on_hand', 'low_stock_threshold', 'image_path'
        ];

    public function inventoryBatches()
    {
        return $this->hasMany(InventoryBatch::class);
    }

    // An item has many logistic items (purchases)
    public function logisticItems()
    {
        return $this->hasMany(LogisticItem::class);
    }

    // An item has many inventory logs (adjustments/history)
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    // Get only adjustment logs
    public function adjustmentLogs()
    {
        return $this->inventoryLogs()->where('type', 'adjustment');
    }

    // Get sales transactions for this item
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}