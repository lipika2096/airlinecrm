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
        Schema::create('air_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number');
            $table->string('emd')->nullable();
            $table->string('mco')->nullable();
            $table->boolean('date_change')->default(false);
            $table->boolean('refund')->default(false);
            $table->date('ticket_issued_from')->nullable();
            $table->date('ticket_issued_to')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('airline');
            $table->decimal('base_fare', 10, 2);
            $table->decimal('taxes', 10, 2);
            $table->decimal('amount_paid_to_airlines', 10, 2);
            $table->decimal('amount_charged_from_pax', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_tickets');
    }
};
