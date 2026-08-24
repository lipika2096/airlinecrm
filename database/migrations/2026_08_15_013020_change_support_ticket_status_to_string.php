<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Direct SQL approach to change enum to string
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN status VARCHAR(255) DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revert back to enum
        DB::statement("ALTER TABLE support_tickets MODIFY COLUMN status ENUM('open', 'in_progress', 'resolved', 'closed') DEFAULT 'open'");
    }
};
