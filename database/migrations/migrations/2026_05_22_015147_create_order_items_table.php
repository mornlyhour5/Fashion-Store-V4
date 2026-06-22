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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable();  // snapshot — survives product deletion
            $table->string('product_name');               // snapshot
            $table->string('sku')->nullable();            // snapshot
            $table->string('color')->nullable();          // snapshot
            $table->string('size')->nullable();           // snapshot
            $table->unsignedInteger('quantity');
            $table->decimal('price', 15, 2);              // unit price at time of order
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->index('order_id');
            $table->index('product_variant_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
