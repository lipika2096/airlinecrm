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
        Schema::create('b2c_passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b2c_customer_id')->constrained('b2c_customers')->onDelete('cascade');
            
            $table->string('passenger_type')->default('adult'); // adult, child, infant
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('passport_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('frequent_flyer_number')->nullable();
            
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
        Schema::dropIfExists('b2c_passengers');
    }
};
