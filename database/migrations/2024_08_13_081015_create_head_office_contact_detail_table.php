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
        Schema::create('head_office_contact_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_id');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position');
            $table->string('department');
            $table->string('email_address');
            $table->string('phone_number');
            $table->timestamp('last_updated_on')->nullable();
            $table->string('last_updated_by')->nullable();
            $table->tinyInteger('status')->default(1); // 1 for active, 2 for inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_office');
    }
};
