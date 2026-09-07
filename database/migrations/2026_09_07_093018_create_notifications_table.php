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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // 'admin' or 'staff'
            $table->string('type'); // 'comment', 'status_update', 'assignment', 'ticket_created'
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data like ticket_id, comment_id, etc.
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('support_ticket_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'user_type']);
            $table->index('support_ticket_id');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
