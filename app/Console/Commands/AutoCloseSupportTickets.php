<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SupportTicket;
use App\Models\SupportTicketSetting;
use App\Models\TicketStatus;
use Carbon\Carbon;

class AutoCloseSupportTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support-tickets:auto-close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically close support tickets based on configured settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-close support tickets process...');

        // Get the support ticket settings
        $settings = SupportTicketSetting::getSettings();

        // Check if auto-close is enabled
        if (!$settings->auto_close_enabled) {
            $this->info('Auto-close feature is disabled. No tickets will be closed.');
            return 0;
        }

        $autoCloseHours = $settings->auto_close_hours;
        $autoCloseStatuses = $settings->getAutoCloseStatusesArrayAttribute();

        if (empty($autoCloseStatuses)) {
            $this->info('No auto-close statuses configured. No tickets will be closed.');
            return 0;
        }

        $this->info("Auto-close settings: {$autoCloseHours} hours for statuses: " . implode(', ', $autoCloseStatuses));

        // Get the closed status slug
        $closedStatusSlug = TicketStatus::where('name', 'Closed')->first()?->slug ?? 'closed';

        // Find tickets that should be auto-closed
        $cutoffTime = Carbon::now()->subHours($autoCloseHours);

        $ticketsToClose = SupportTicket::whereIn('status', $autoCloseStatuses)
            ->where('updated_at', '<=', $cutoffTime)
            ->where('status', '!=', $closedStatusSlug)
            ->get();

        $closedCount = 0;

        foreach ($ticketsToClose as $ticket) {
            try {
                $ticket->status = $closedStatusSlug;
                $ticket->closed_at = now();
                if (!$ticket->resolved_at) {
                    $ticket->resolved_at = now();
                }
                $ticket->save();
                
                $this->info("Closed ticket #{$ticket->ticket_number} (ID: {$ticket->id})");
                $closedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to close ticket #{$ticket->ticket_number} (ID: {$ticket->id}): " . $e->getMessage());
            }
        }

        $this->info("Auto-close process completed. {$closedCount} tickets were closed.");
        return 0;
    }
}
