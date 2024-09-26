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
        Schema::table('airlines', function (Blueprint $table) {
            $table->dropColumn(['airline_ticketing_code', 'airline_contact_details','rules_do','rules_dont','standard_cancellation_charges','date_change_charges','routes_flown_from','routes_flown_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airlines', function (Blueprint $table) {
            //
        });
    }
};
