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
        Schema::table('b2_b_partner_documents', function (Blueprint $table) {
            $table->enum('document_type', ['Agreement', 'TSA', 'Contract', 'License', 'Other'])->default('Other')->after('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2_b_partner_documents', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }
};
