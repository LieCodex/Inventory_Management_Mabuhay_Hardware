<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'source_logistic_item_id', 'quantity_remaining', 
        'price', 'expiry_date', 'received_at'
    ];

    // Defining the ERD Relationship: An Inventory Batch belongs to a specific Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}