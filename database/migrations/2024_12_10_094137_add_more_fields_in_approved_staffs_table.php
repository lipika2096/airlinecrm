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
        Schema::table('approved_staffs', function (Blueprint $table) {
            $table->string('deleted_at')->nullable();
            $table->string('remarks')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_at')->nullable()->change();
            $table->string('duties')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approved_staffs', function (Blueprint $table) {
            $table->dropColumn(['status','deleted_at', 'created_by','updated_by', 'remarks','duties']);
            //
        });
    }
};
