<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'total_amount',
        'transaction_date',
    ];

    // A transaction has many transaction items
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
