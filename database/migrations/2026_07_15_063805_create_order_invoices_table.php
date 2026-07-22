<?php

use App\Traits\BaseMigrationField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use BaseMigrationField;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_invoices', function (Blueprint $table) {
            $this->AddBaseFields($table);
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('code');
            $table->dateTimeTz('issue_at');
            $table->decimal('discount', 10, 5)->default(0);
            $table->decimal('discount_amount', 10, 5)->default(0);
            $table->decimal('tax_rate', 10, 5)->default(0);
            $table->decimal('tax_amount', 10, 5)->default(0);
            $table->decimal('pain_amount', 10, 5)->default(0);
            $table->decimal('due_amount', 10, 5)->default(0);
            $table->unsignedBigInteger('payment_status_id');
            $table->unsignedBigInteger('status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_invoices');
    }
};
