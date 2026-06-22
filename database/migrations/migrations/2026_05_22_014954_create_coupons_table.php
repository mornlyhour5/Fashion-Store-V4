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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();


            //                                    future update V.5
            // $table->string('code')->unique();
            // $table->string('type');                        // percentage | fixed
            // $table->decimal('value', 10, 2);              // % amount or flat amount
            // $table->decimal('minimum_order', 15, 2)->default(0);
            // $table->decimal('maximum_discount', 15, 2)->nullable();  // cap for percentage coupons
            // $table->unsignedInteger('usage_limit')->nullable();      // null = unlimited
            // $table->unsignedInteger('usage_count')->default(0);
            // $table->boolean('is_active')->default(true);
            // $table->timestamp('starts_at')->nullable();
            // $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            // $table->softDeletes();

            // $table->index('code');
            // $table->index('is_active');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
