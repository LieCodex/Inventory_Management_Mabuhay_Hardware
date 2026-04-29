<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logistic_items', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('supplier');
            $table->timestamp('processed_at')->nullable()->after('status');
        });

        DB::table('logistic_items')->whereNull('status')->update(['status' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('logistic_items', function (Blueprint $table) {
            $table->dropColumn(['status', 'processed_at']);
        });
    }
};
