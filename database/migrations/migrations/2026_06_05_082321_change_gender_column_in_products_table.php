<?php

use App\Enums\GenderProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Step 1: Add new string column (gender was string, not boolean)
            $table->string('gender_new')->nullable();
        });

        // Step 2: Migrate existing string data → normalized enum values
        // gender in products was: men | women | unisex | kids
        DB::statement("
            UPDATE products
            SET gender_new = CASE
                WHEN LOWER(gender) = 'men'    THEN '" . GenderProduct::MEN->value    . "'
                WHEN LOWER(gender) = 'women'  THEN '" . GenderProduct::WOMEN->value  . "'
                WHEN LOWER(gender) = 'kids'   THEN '" . GenderProduct::KIDS->value   . "'
                ELSE                               '" . GenderProduct::UNISEX->value  . "'
            END
        ");

        Schema::table('products', function (Blueprint $table) {
            // Step 3: Drop old column
            $table->dropColumn('gender');
        });

        Schema::table('products', function (Blueprint $table) {
            // Step 4: Rename new column to gender
            $table->renameColumn('gender_new', 'gender');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('gender_old')->nullable();
        });

        DB::statement("
            UPDATE products
            SET gender_old = CASE
                WHEN gender = '" . GenderProduct::MEN->value    . "' THEN 'men'
                WHEN gender = '" . GenderProduct::WOMEN->value  . "' THEN 'women'
                WHEN gender = '" . GenderProduct::KIDS->value   . "' THEN 'kids'
                ELSE                                                   'unisex'
            END
        ");

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('gender_old', 'gender');
        });
    }
};
