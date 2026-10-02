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
        Schema::table('module_permissions', function (Blueprint $table) {
            // Add sub-module permissions as JSON columns
            $table->json('permissions')->nullable()->after('has_access');
            $table->boolean('can_view')->default(false)->after('permissions');
            $table->boolean('can_create')->default(false)->after('can_view');
            $table->boolean('can_edit')->default(false)->after('can_create');
            $table->boolean('can_delete')->default(false)->after('can_edit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_permissions', function (Blueprint $table) {
            $table->dropColumn(['permissions', 'can_view', 'can_create', 'can_edit', 'can_delete']);
        });
    }
};
