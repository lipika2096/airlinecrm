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
        // Add title and gender to booking_passengers table
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->string('title')->nullable()->after('booking_id');
            $table->string('gender')->nullable()->after('title');
        });

        // Split name into first_name and last_name
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->string('first_name')->after('gender');
            $table->string('last_name')->nullable()->after('first_name');
        });

        // Add remarks to booking_payments table
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('status');
        });

        // Add invoice fields to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('updated_by');
            $table->date('invoice_date')->nullable()->after('invoice_number');
            $table->date('invoice_due_date')->nullable()->after('invoice_date');
            $table->decimal('invoice_tax_rate', 5, 2)->nullable()->after('invoice_due_date');
            $table->text('invoice_notes')->nullable()->after('invoice_tax_rate');
            $table->text('billing_address')->nullable()->after('invoice_notes');
            $table->text('shipping_address')->nullable()->after('billing_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove title and gender from booking_passengers table
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropColumn(['title', 'gender']);
        });

        // Remove first_name and last_name from booking_passengers table
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });

        // Remove remarks from booking_payments table
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });

        // Remove invoice fields from bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number',
                'invoice_date',
                'invoice_due_date',
                'invoice_tax_rate',
                'invoice_notes',
                'billing_address',
                'shipping_address'
            ]);
        });
    }
};
