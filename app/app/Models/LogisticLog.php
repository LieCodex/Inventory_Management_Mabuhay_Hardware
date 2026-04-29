<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticLog extends Model
{
    use HasFactory;

    protected $table = 'logistic_logs';

    protected $fillable = [
        'date',
        'logistic_company',
    ];

    // A logistic log has many logistic items
    public function logisticItems()
    {
        return $this->hasMany(LogisticItem::class, 'logs_id');
    }
}
