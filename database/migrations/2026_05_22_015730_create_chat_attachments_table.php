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
        Schema::create('chat_attachments', function (Blueprint $table) {
            $table->id();

            //                            future Update V.6
            // $table->foreignId('message_id')->constrained('chat_messages')->onDelete('cascade');
            // $table->string('file_url');
            // $table->string('file_name');
            // $table->string('file_type')->nullable();                // image/jpeg | application/pdf | etc.
            // $table->unsignedBigInteger('file_size')->nullable();    // bytes
            $table->timestamps();

            // $table->index('message_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_attachments');
    }
};
