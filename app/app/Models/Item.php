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
            'quantity_on_hand', 'low_stock_threshold'
        ];

    public function inventoryBatches()
    {
        return $this->hasMany(InventoryBatch::class);
    }
}