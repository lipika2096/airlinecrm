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
        Schema::create('b2c_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_type')->default('individual');
            $table->string('salutation')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->default('active');
            
            // Travel preferences
            $table->string('preferred_airline')->nullable();
            $table->string('preferred_class')->nullable();
            $table->string('meal_preference')->nullable();
            $table->string('seat_preference')->nullable();
            $table->text('special_requests')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2c_customers');
    }
};
