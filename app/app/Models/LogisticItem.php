<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticItem extends Model
{
    use HasFactory;

    protected $table = 'logistic_items';

    protected $fillable = [
        'logs_id',
        'item_id',
        'quantity',
        'unit_cost',
        'expiry_date',
        'supplier',
        'status',
        'processed_at',
    ];

    // A logistic item belongs to an item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // A logistic item belongs to a logistic log
    public function logisticLog()
    {
        return $this->belongsTo(LogisticLog::class, 'logs_id');
    }
}
