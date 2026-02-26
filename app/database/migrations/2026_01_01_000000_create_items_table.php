<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->comment('Stock Keeping Unit');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit_of_measure')->comment('e.g., pcs, bags, boxes');
            $table->string('pricing_type')->nullable();
            $table->decimal('price_per_unit', 10, 2);
            $table->string('barcode')->unique()->nullable();
            $table->integer('quantity_on_hand')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};