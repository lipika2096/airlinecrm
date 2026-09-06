<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;

use App\Models\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketStatusController extends Controller
{
    public function index()
    {
        $ticketStatuses = TicketStatus::orderBy('sort_order')->get();
        return view('admin.ticket-status.index', compact('ticketStatuses'));
    }

    public function create()
    {
        return view('admin.ticket-status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_statuses',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $slug = \Str::slug($request->name);

        TicketStatus::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->has('is_active') ? true : false,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.ticket-status.index')
            ->with('success', 'Ticket status created successfully.');
    }

    public function edit(TicketStatus $ticketStatus)
    {
        return view('admin.ticket-status.edit', compact('ticketStatus'));
    }

    public function update(Request $request, TicketStatus $ticketStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_statuses,name,' . $ticketStatus->id,
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $slug = \Str::slug($request->name);

        $ticketStatus->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->has('is_active') ? true : false,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.ticket-status.index')
            ->with('success', 'Ticket status updated successfully.');
    }

    public function destroy(TicketStatus $ticketStatus)
    {
        $ticketStatus->delete();
        return redirect()->route('admin.ticket-status.index')
            ->with('success', 'Ticket status deleted successfully.');
    }
}
