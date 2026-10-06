<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SupportTicket;

class UpdateTicketNumberFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all support tickets
        $tickets = SupportTicket::all();

        foreach ($tickets as $ticket) {
            // Check if ticket number is in old format (TKT-XXXXXX)
            if (str_starts_with($ticket->ticket_number, 'TKT-')) {
                // Generate new format: ID-random(6)
                $newTicketNumber = $ticket->id . '-' . strtoupper(Str::random(6));

                // Update the ticket number
                $ticket->ticket_number = $newTicketNumber;
                $ticket->save();

                $this->command->info("Updated ticket ID {$ticket->id}: {$ticket->ticket_number} -> {$newTicketNumber}");
            } elseif (str_starts_with($ticket->ticket_number, 'TEMP-')) {
                // Update temporary ticket numbers
                $newTicketNumber = $ticket->id . '-' . strtoupper(Str::random(6));

                // Update the ticket number
                $ticket->ticket_number = $newTicketNumber;
                $ticket->save();

                $this->command->info("Updated temporary ticket ID {$ticket->id}: {$ticket->ticket_number} -> {$newTicketNumber}");
            } else {
                // Skip tickets that are already in the new format
                $this->command->info("Skipped ticket ID {$ticket->id}: already in new format ({$ticket->ticket_number})");
            }
        }

        $this->command->info('Ticket number format update completed successfully.');
    }
}
