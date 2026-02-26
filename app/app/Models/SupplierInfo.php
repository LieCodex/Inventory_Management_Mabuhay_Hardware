<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInfo extends Model
{
    use HasFactory;

    protected $table = 'supplier_info'; 

    protected $fillable = [
        'company_name', 
        'item_id', 
        'contact_number', 
        'email', 
        'quantity_on_the_way', 
        'eta'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}