<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::where('name', 'employee')->delete();
        Role::where('name', 'admin')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::create(['name' => 'employee', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
    }
};
