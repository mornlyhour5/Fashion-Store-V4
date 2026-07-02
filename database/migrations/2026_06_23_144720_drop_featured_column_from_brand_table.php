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
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('featured');
        });
    }

    public function down(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->boolean('featured')->default(false)->after('logo');
        });
    }
};
