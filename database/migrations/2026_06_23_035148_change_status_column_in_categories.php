<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('status')->default(Status::ACTIVE->value);
        });

        DB::statement('
        UPDATE categories
        SET status = CASE
            WHEN is_active = TRUE THEN ' . Status::ACTIVE->value . '
            ELSE ' . Status::INACTIVE->value . '
        END
        ');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active_old')->default(true);
        });

        DB::statement('
            UPDATE categories
            SET is_active_old = CASE
                WHEN is_active = ' . Status::ACTIVE->value . ' THEN TRUE
                ELSE FALSE
            END
        ');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
