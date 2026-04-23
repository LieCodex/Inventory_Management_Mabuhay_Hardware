<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Allow these fields to be filled during mass assignment
    protected $fillable = [
        'total_amount',
        'transaction_date',
    ];

    // Define the relationship: A transaction has many items
    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}