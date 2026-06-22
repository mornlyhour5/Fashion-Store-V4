<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Enums\Gender;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 1: Add new enum-backed column alongside old one
            $table->string('gender_new')->nullable();
        });

        // Step 2: Migrate existing string data → normalized enum values
        DB::statement("
            UPDATE customer_profile
            SET gender_new = CASE
                WHEN LOWER(gender) IN ('male', 'm')          THEN '" . Gender::MALE->value . "'
                WHEN LOWER(gender) IN ('female', 'f')        THEN '" . Gender::FEMALE->value . "'
                WHEN LOWER(gender) IN ('unisex', 'u')         THEN '" . Gender::UNISEX->value . "'
                ELSE NULL
            END
        ");

        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 3: Drop old string column
            $table->dropColumn('gender');
        });

        Schema::table('customer_profile', function (Blueprint $table) {
            // Step 4: Rename new column to gender
            $table->renameColumn('gender_new', 'gender');
        });
    }

    public function down(): void
    {
        Schema::table('customer_profile', function (Blueprint $table) {
            $table->string('gender_old')->nullable();
        });

        // Restore values back to plain strings
        DB::statement("
            UPDATE customer_profile
            SET gender_old = CASE
                WHEN gender = '" . Gender::MALE->value   . "' THEN 'male'
                WHEN gender = '" . Gender::FEMALE->value . "' THEN 'female'
                WHEN gender = '" . Gender::UNISEX->value  . "' THEN 'unisex'
                ELSE NULL
            END
        ");

        Schema::table('customer_profile', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('customer_profile', function (Blueprint $table) {
            $table->renameColumn('gender_old', 'gender');
        });
    }
};
