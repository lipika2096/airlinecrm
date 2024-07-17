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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('infant_id')->nullable();
            $table->string('base_fair', 10, 2)->nullable();
            $table->string('totel_pnr_cost', 10, 2)->nullable();
            $table->string('origin_id')->nullable();
            $table->string('destination_id')->nullable();
            $table->string('sale_rate', 10, 2)->nullable();
            $table->string('buy_rate', 10, 2)->nullable();
            $table->string('other_exp', 10, 2)->nullable();
            $table->string('airline_id')->nullable();
            $table->string('p_no')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('name')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('terminal')->nullable();
            $table->string('ret_airline_id')->nullable();
            $table->string('ret_pnr_no')->nullable();
            $table->string('return_time')->nullable();
            $table->string('arrival_terminal')->nullable();
            $table->string('ret_arrival_time')->nullable();
            $table->string('ret_flight_no')->nullable();
            $table->string('ret_terminal')->nullable();
            $table->string('return_date')->nullable();
            $table->string('way')->nullable();
            $table->string('availabilty')->nullable();
            $table->string('rate_type')->nullable();
            $table->string('sales_stop_date')->nullable();
            $table->string('departure_date_from')->nullable();
            $table->string('departure_date_to')->nullable();
            $table->string('availability')->nullable();
            $table->string('seat')->nullable();
            $table->string('date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('image')->nullable();
            $table->string('tax', 10, 2)->nullable();
            $table->string('p_tax', 10, 2)->nullable();
            $table->integer('infant')->nullable();
            $table->integer('adult')->nullable();
            $table->integer('child')->nullable();
            $table->string('term')->nullable();
            $table->string('charges')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
