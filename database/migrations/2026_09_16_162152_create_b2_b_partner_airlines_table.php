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
        Schema::create('b2_b_partner_airlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b2b_partner_id')->constrained('b2_b_partners')->onDelete('cascade');
            $table->foreignId('airline_id')->nullable()->constrained('airlines')->onDelete('set null');
            $table->string('airline_name')->nullable();
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
        Schema::dropIfExists('b2_b_partner_airlines');
    }
};
