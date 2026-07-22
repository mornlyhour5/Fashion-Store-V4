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
        Schema::create('stock_movements', function (Blueprint $table) {
            $this->AddBaseFields($table);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_id');
            $table->string('action', 25);
            $table->decimal('quantity', 15, 5);
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->integer('reference_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->unsignedBigInteger('action_uid');
            $table->dateTimeTz('action_at')->default(now());
            $table->text('note');
            $table->jsonb('meta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
