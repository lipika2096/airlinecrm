<?php

namespace App\Exports;

use App\Models\SupportTicket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SupportTicketReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets;
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'Subject',
            'Department',
            'Priority',
            'Status',
            'Created By',
            'Assigned To',
            'Company Name',
            'Booking Reference',
            'Created At',
            'Resolved At',
            'Closed At',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->subject,
            $ticket->department,
            $ticket->priority,
            $ticket->ticketStatus ? $ticket->ticketStatus->name : $ticket->status,
            $ticket->creator_name,
            $ticket->assignedTo ? ($ticket->assignedTo->name ?? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name) : 'Unassigned',
            $ticket->company_name,
            $ticket->booking_reference ?? 'N/A',
            $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i:s') : 'N/A',
            $ticket->resolved_at ? $ticket->resolved_at->format('Y-m-d H:i:s') : 'N/A',
            $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0']
                ]
            ],
        ];
    }
}
