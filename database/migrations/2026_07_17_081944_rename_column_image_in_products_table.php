<?php

use App\Enums\FeaturedStatus;
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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('image', 'thumbnail');
            $table->text('short_description')->nullable();
            $table->string('material')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->decimal('weight')->nullable();
            $table->integer('is_featured')->default(FeaturedStatus::NOT_FEATURED->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
