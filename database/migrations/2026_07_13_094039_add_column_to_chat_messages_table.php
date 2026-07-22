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
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');     // customer or admin/staff
            $table->string('sender_role');                          // customer | admin | staff — snapshot so it survives role changes
            $table->text('body')->nullable();                       // null when the message is attachment-only
            $table->string('type')->default('text');                // text | image | file | system
            $table->timestamp('read_at')->nullable();               // when the other party read it
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
