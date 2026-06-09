<?php

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Step 1: Add a new temporary integer column
            $table->tinyInteger('status_new')->default(ProductStatus::ACTIVE->value);
        });

        // Step 2: Migrate data — PostgreSQL boolean needs explicit cast
        DB::statement('
            UPDATE products
            SET status_new = CASE
                WHEN status = TRUE THEN ' . ProductStatus::ACTIVE->value . '
                ELSE ' . ProductStatus::INACTIVE->value . '
            END
        ');

        Schema::table('products', function (Blueprint $table) {
            // Step 3: Drop old boolean column
            $table->dropColumn('status');
        });

        Schema::table('products', function (Blueprint $table) {
            // Step 4: Rename new column to status
            $table->renameColumn('status_new', 'status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status_old')->default(true);
        });

        DB::statement('
            UPDATE products
            SET status_old = CASE
                WHEN status = ' . ProductStatus::ACTIVE->value . ' THEN TRUE
                ELSE FALSE
            END
        ');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('status_old', 'status');
        });
    }
};
