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
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->string('absence_series')->nullable();
            $table->string('representation')->nullable();
            $table->string('half')->default('0');
            $table->string('formerly')->default('0');
            $table->string('afternoon')->default('0');
            $table->string('note')->nullable();
            $table->string('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            //
        });
    }
};
