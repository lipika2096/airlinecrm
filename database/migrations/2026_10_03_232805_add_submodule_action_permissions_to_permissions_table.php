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
        Schema::table('permissions', function (Blueprint $table) {
            $table->boolean('can_view')->default(false)->after('description');
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
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['can_view', 'can_create', 'can_edit', 'can_delete']);
        });
    }
};
