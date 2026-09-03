<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Open',
                'slug' => 'open',
                'description' => 'Ticket is newly created and awaiting attention',
                'color' => '#6c757d',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'In Progress',
                'slug' => 'in_progress',
                'description' => 'Ticket is currently being worked on',
                'color' => '#ffc107',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Resolved',
                'slug' => 'resolved',
                'description' => 'Ticket has been resolved but not yet closed',
                'color' => '#28a745',
                'is_active' => true,
                'sort_order' => 3,
            ],
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
            [
                'name' => 'Closed',
                'slug' => 'closed',
                'description' => 'Ticket has been closed',
                'color' => '#dc3545',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'On Hold',
                'slug' => 'on_hold',
                'description' => 'Ticket is temporarily on hold',
                'color' => '#17a2b8',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Escalated',
                'slug' => 'escalated',
                'description' => 'Ticket has been escalated to higher level support',
                'color' => '#fd7e14',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($statuses as $status) {
            TicketStatus::updateOrCreate(
                ['slug' => $status['slug']],
                $status
            );
        }
    }
}
