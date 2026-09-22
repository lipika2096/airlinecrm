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
        Schema::create('b2_b_partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_code')->unique();
            $table->string('partner_name');
            $table->enum('partner_type', ['Travel Agent', 'Tour Operator', 'Corporate', 'TMC']);
            $table->string('iata_tids_no')->nullable();
            $table->string('country');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Active', 'Pending', 'Inactive'])->default('Pending');
            $table->string('responsible_person')->nullable();
            $table->string('region')->nullable();
            $table->string('airline_responsibility')->nullable();
            $table->string('product_responsibility')->nullable();
            $table->enum('tsa_status', ['Activated', 'Deactivated'])->nullable();
            $table->integer('total_bookings')->default(0);
            $table->integer('total_passengers')->default(0);
            $table->decimal('revenue', 15, 2)->default(0);
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
        Schema::dropIfExists('b2_b_partners');
    }
};
