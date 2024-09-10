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
        Schema::table('airline_libraries', function (Blueprint $table) {
            $table->string('edition_no')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->string('uploaded_by')->nullable(); 
            $table->timestamp('uploaded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airline_libraries', function (Blueprint $table) {
            //
        });
    }
};
