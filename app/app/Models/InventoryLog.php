<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $table = 'inventory_logs';

    protected $fillable = [
        'item_id',
        'type',
        'quantity_change',
        'remarks',
    ];

    // An inventory log belongs to an item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
