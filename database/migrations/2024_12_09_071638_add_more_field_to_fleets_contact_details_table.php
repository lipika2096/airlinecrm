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
        Schema::table('fleets', function (Blueprint $table) {
            //
            $table->string('deleted_at')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('remarks')->nullable();
            $table->string('updated_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fleets', function (Blueprint $table) {
            $table->dropColumn(['deleted_at', 'created_by','updated_by', 'remarks']);
        });
    }
};
