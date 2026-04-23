<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->decimal('total_amount', 10, 2); // Revenue
        $table->decimal('total_cost', 10, 2);   // Cost of goods sold
        $table->decimal('profit', 10, 2);
        $table->timestamps();
    });

    Schema::create('sale_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_id')->constrained();
        $table->foreignId('item_id')->constrained();
        $table->integer('quantity');
        $table->decimal('price_at_sale', 10, 2); // Price at moment of purchase
        $table->timestamps();
    });
}
};
