<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Enums\Language;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 1: Add new column alongside old one
            $table->string('preferred_language_new')->nullable();
        });

        // Step 2: Migrate existing data → normalized enum values
        DB::statement("
            UPDATE customer_profile
            SET preferred_language_new = CASE
                WHEN UPPER(preferred_language) IN ('EN', 'ENGLISH')  THEN '" . Language::EN->value . "'
                WHEN UPPER(preferred_language) IN ('KH', 'KHMER')    THEN '" . Language::KH->value . "'
                ELSE '" . Language::EN->value . "'
            END
        ");

        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 3: Drop old column
            $table->dropColumn('preferred_language');
        });

        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 4: Rename new column
            $table->renameColumn('preferred_language_new', 'preferred_language');
        });
    }

    public function down(): void
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            $table->string('preferred_language_old')->nullable();
        });

        DB::statement("
            UPDATE customer_profile
            SET preferred_language_old = CASE
                WHEN preferred_language = '" . Language::EN->value . "' THEN 'EN'
                WHEN preferred_language = '" . Language::KH->value . "' THEN 'KH'
                ELSE 'EN'
            END
        ");

        Schema::table('customer_profile', function (Blueprint $table) {
            $table->dropColumn('preferred_language');
        });

        Schema::table('customer_profile', function (Blueprint $table) {
            $table->renameColumn('preferred_language_old', 'preferred_language');
        });
    }
};
