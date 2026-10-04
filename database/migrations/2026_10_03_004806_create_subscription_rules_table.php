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
        Schema::create('subscription_rules', function (Blueprint $table) {
            $table->id();
            $table->string('billing_frequency')->default('monthly'); // monthly, yearly
            $table->decimal('annual_discount', 5, 2)->default(0); // percentage
            $table->boolean('proration_first_month')->default(true);
            $table->string('billing_cycle')->default('calendar_month'); // calendar_month, etc.
            $table->string('cancellation_policy')->default('end_of_current_month'); // end_of_current_month, etc.
            $table->string('minimum_subscription_period')->default('1 Month');
            $table->string('notice_period')->default('0 Days');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_rules');
    }
};
