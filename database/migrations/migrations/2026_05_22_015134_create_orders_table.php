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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete(); // structured address


            //                                    future update V.5
            // $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();


            $table->string('order_number')->unique();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_method');             // cod | card | bank_transfer | e-wallet
            $table->string('payment_status')->default('pending');  // pending | paid | failed | refunded
            $table->string('order_status')->default('pending');    // pending | confirmed | shipped | delivered | cancelled
            $table->text('shipping_address');             // JSON snapshot — preserved even if address deleted
            $table->text('note')->nullable();             // customer note on the order
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('order_status');
            $table->index('payment_status');
            // $table->index('coupon_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
