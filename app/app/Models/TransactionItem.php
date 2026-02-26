<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    // A transaction item belongs to a specific hardware item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}