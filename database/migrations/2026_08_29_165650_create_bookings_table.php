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
        Schema::dropIfExists('bookings');

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_no')->unique();
            $table->date('booking_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_type')->default('individual');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('booking_notes')->nullable();
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->decimal('total_sell', 10, 2)->default(0);
            $table->decimal('profit', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Invoice fields
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('invoice_due_date')->nullable();
            $table->decimal('invoice_tax_rate', 5, 2)->nullable();
            $table->text('invoice_notes')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
        });
        
        // Booking Services table
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('service_type');
            $table->string('description')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('sell', 10, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
        
        // Booking Passengers table
        Schema::create('booking_passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('title')->nullable();
            $table->string('gender')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
        
        // Booking Payments table
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->default('cash');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
        
        // Booking Documents table
        Schema::create('booking_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('document_type');
            $table->string('document_name');
            $table->string('document_file')->nullable();
            $table->timestamps();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
