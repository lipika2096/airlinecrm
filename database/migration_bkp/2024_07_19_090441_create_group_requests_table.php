<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_requests', function (Blueprint $table) {
            $table->id(); // id field createe which auto inc. , primary key
            $table->text('request_id');
            $table->date('raised_date');
            $table->string('flight_number');
            $table->string('trip_type');
            $table->string('departure');
            $table->string('arrival');
            $table->date('travel_date');
            $table->string('pax_count');
            $table->string('class_type');
            $table->integer('request_status');
            $table->timestamps(); // create fields created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_requests');
    }
}
