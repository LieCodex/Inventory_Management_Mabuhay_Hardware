<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->index('transaction_date'); // Crucial for MoM/YoY queries
    });

    Schema::table('transaction_items', function (Blueprint $table) {
        $table->index('transaction_id');
        $table->index('item_id');
        $table->index('batch_id');
        $table->index('created_at');
    });
}
};
