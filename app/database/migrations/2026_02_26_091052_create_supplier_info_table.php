<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_info', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Replaced 'product'
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('quantity_on_the_way')->default(0);
            $table->date('eta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_info');
    }
};