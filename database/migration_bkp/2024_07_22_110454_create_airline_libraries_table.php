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
        Schema::create('airline_libraries', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->unsignedBigInteger('airline_id'); // Foreign key for airline
            $table->string('no_of_documents'); // Column for number of documents
            $table->timestamps(); // Created at and updated at timestamps


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_libraries');
    }
};
