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
        Schema::create('department_modules', function (Blueprint $table) {
            $table->id();
            $table->string('department_name');
            $table->string('module_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('department_name');
            $table->index('module_name');
            $table->unique(['department_name', 'module_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_modules');
    }
};
