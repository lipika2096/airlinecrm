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
        Schema::table('bookings', function (Blueprint $table) {
            // B2C Customer Details
            $table->string('b2c_first_name')->nullable();
            $table->string('b2c_last_name')->nullable();
            $table->string('b2c_email')->nullable();
            $table->string('b2c_phone')->nullable();
            $table->string('b2c_street')->nullable();
            $table->string('b2c_house_no')->nullable();
            $table->string('b2c_city')->nullable();
            $table->string('b2c_pincode')->nullable();
            $table->string('b2c_state')->nullable();
            $table->string('b2c_country')->nullable();
            $table->string('b2c_language')->nullable();
            $table->string('b2c_responsible')->nullable();
            $table->text('b2c_remarks')->nullable();

            // B2B Customer Details
            $table->string('b2b_group')->nullable();
            $table->string('b2b_company_name')->nullable();
            $table->string('b2b_email')->nullable();
            $table->string('b2b_phone')->nullable();
            $table->string('b2b_street')->nullable();
            $table->string('b2b_house_no')->nullable();
            $table->string('b2b_city')->nullable();
            $table->string('b2b_pincode')->nullable();
            $table->string('b2b_state')->nullable();
            $table->string('b2b_country')->nullable();
            $table->string('b2b_language')->nullable();
            $table->string('b2b_responsible')->nullable();
            $table->text('b2b_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // B2C Customer Details
            $table->dropColumn([
                'b2c_first_name', 'b2c_last_name', 'b2c_email', 'b2c_phone',
                'b2c_street', 'b2c_house_no', 'b2c_city', 'b2c_pincode',
                'b2c_state', 'b2c_country', 'b2c_language', 'b2c_responsible',
                'b2c_remarks'
            ]);

            // B2B Customer Details
            $table->dropColumn([
                'b2b_group', 'b2b_company_name', 'b2b_email', 'b2b_phone',
                'b2b_street', 'b2b_house_no', 'b2b_city', 'b2b_pincode',
                'b2b_state', 'b2b_country', 'b2b_language', 'b2b_responsible',
                'b2b_remarks'
            ]);
        });
    }
};
