<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_case_histories', function (Blueprint $table) {
            DB::table('customer_case_histories')->truncate();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->dropColumn('agent_id');
            $table->dropColumn('airline_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_case_histories', function (Blueprint $table) {
            DB::table('customer_case_histories')->truncate();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->dropColumn('customer_id');
            $table->string('airline_id')->nullable();
        });
    }
};
