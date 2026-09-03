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
    public function up(): void
    {
        // Add new ticket statuses if they don't exist
        $statuses = [
            [
                'name' => 'Reopened',
                'slug' => 'reopened',
                'description' => 'Ticket has been reopened after being closed',
                'color' => '#6610f2',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Waiting Feedback',
                'slug' => 'waiting_feedback',
                'description' => 'Ticket is waiting for customer feedback',
                'color' => '#e83e8c',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('ticket_statuses')->updateOrInsert(
                ['slug' => $status['slug']],
                $status
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the new ticket statuses
        DB::table('ticket_statuses')->whereIn('slug', ['reopened', 'waiting_feedback'])->delete();
    }
};
