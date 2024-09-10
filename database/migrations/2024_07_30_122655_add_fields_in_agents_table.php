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
        Schema::table('agents', function (Blueprint $table) {
            //
            $table->string('focus_destinations');
            $table->string('parent_company');
            $table->string('headquarters');
            $table->string('key_people');
            $table->string('websites');
            $table->string('no_of_employees');
            $table->string('iata');
            $table->string('gds_type');
            $table->string('pcc_office_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            //
        });
    }
};
