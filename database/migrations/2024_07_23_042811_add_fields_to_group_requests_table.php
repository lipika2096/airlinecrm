<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToGroupRequestsTable extends Migration
{
    /**phpp
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('group_requests', function (Blueprint $table) {
            $table->string('group_name')->nullable();
            $table->string('tour_name')->nullable();
            $table->string('group_type')->nullable();
            $table->string('corporate')->nullable();
            $table->string('corporate_code')->nullable();
            $table->date('flexible_travel_date')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->timestamp('flight_time')->nullable();
            $table->string('travel_duration')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('expected_fare')->default(0);
            $table->string('notify_others')->nullable();
            $table->string('remark')->nullable();
            $table->string('departure_origin')->nullable();
            $table->string('departure_destination')->nullable();
            $table->timestamp('departure_flight_time')->nullable();
            $table->string('departure_travel_duration')->nullable();
            $table->date('departure_arrival_date')->nullable();
            $table->date('departure_travel_date')->nullable();
            $table->string('departure_flight_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_requests', function (Blueprint $table) {
            //
        });
    }
};
