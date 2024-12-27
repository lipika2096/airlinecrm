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
        Schema::table('calenders', function (Blueprint $table) {
            $table->string('website')->nullable();
            $table->string('email_id')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('remarks')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_at')->default('null')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calenders', function (Blueprint $table) {
            $table->dropColumn(['website', 'email_id', 'phone_no', 'contact_person', 'remarks', 'created_by', 'updated_by']);
        });
    }
};
