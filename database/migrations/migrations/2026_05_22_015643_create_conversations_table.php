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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            //                            future Update V.6
            // $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');   // the customer side
            // $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // admin/staff handling it
            // $table->string('subject')->nullable();                  // optional topic, e.g. "Order #00123 issue"
            // $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete(); // link to a specific order if relevant
            // $table->string('status')->default('open');              // open | pending | resolved | closed
            // $table->timestamp('last_message_at')->nullable();       // for sorting inbox by recent activity
            // $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            // $table->softDeletes();

            // $table->index('customer_id');
            // $table->index('assigned_to');
            // $table->index('status');
            // $table->index('last_message_at');
            // $table->index('order_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
