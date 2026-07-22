<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('net_amount', 10, 5)->default(0);
            $table->decimal('tax_rate', 10, 5)->default(0);
            $table->decimal('tax_amount', 10,5)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('net_amount', 10, 5)->default(0);
            $table->decimal('tax_rate', 10, 5)->default(0);
            $table->decimal('tax_amount', 10,5)->default(0);
        });
    }
};
