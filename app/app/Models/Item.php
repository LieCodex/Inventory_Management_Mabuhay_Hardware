<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // These are the columns we are allowed to fill via forms
    protected $fillable = [
        'sku', 'name', 'description', 'unit_of_measure', 
        'pricing_type', 'price_per_unit', 'barcode', 
        'quantity_on_hand', 'low_stock_threshold'
    ];

    // Defining the ERD Relationship: One Item has many Inventory Batches
    public function inventoryBatches()
    {
        return $this->hasMany(InventoryBatch::class);
    }
}