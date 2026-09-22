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
            // Add b2b_partner_id if it doesn't exist
            if (!Schema::hasColumn('bookings', 'b2b_partner_id')) {
                $table->unsignedBigInteger('b2b_partner_id')->nullable()->after('customer_type');
                $table->foreign('b2b_partner_id')->references('id')->on('b2_b_partners')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['b2b_partner_id']);
            $table->dropColumn('b2b_partner_id');
        });
    }
};
