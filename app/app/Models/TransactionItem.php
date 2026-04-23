<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    // Define the fields that are allowed to be mass-assigned
    protected $fillable = [
        'transaction_id',
        'item_id',
        'batch_id',
        'quantity',
        'price_at_sale',
        'subtotal',
    ];

    // A transaction item belongs to a specific hardware item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}