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
        Schema::create('staff_read_signs', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id');
            $table->string('doc_name');
            $table->string('attachment');
            $table->string('airline_id');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_at')->nullable();
            $table->string('sign_doc')->nullable();
            $table->timestamps();
            $table->string('updated_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_read_signs');
    }
};
