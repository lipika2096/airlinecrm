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
                'name' => 'Closed',
                'slug' => 'closed',
                'description' => 'Ticket has been closed',
                'color' => '#dc3545',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'On Hold',
                'slug' => 'on_hold',
                'description' => 'Ticket is temporarily on hold',
                'color' => '#17a2b8',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Escalated',
                'slug' => 'escalated',
                'description' => 'Ticket has been escalated to higher level support',
                'color' => '#fd7e14',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($statuses as $status) {
            TicketStatus::create($status);
        }
    }
}
