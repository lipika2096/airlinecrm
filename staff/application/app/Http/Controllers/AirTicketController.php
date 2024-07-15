<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirTicket;
use Illuminate\Support\Facades\Auth;
use App\Models\Airline;
class AirTicketController extends Controller
{
    public function index()
    {
        $agentId = Auth::id();
        $airTickets = AirTicket::where('agent_id', $agentId)->get();
        return view('airtickets.index', compact('airTickets'));
    }

    public function create()
    {
        $airlines = Airline::pluck('airline_code', 'id'); // Fetch all airlines from the 'airlines' table
        return view('airtickets.create', compact('airlines'));
    }

    public function store(Request $request)
{
    $request->validate([
        // Validation rules here
    ]);

    $airTicket = AirTicket::create([
        'agent_id' => Auth::id(),
        'ticket_number' => $request->input('ticket_number'),
        'emd' => $request->input('emd'),
        'mco' => $request->input('mco'),
        'date_change' => $request->has('date_change'),
        'refund' => $request->has('refund'),
        'ticket_issued_from' => $request->input('ticket_issued_from'),
        'ticket_issued_to' => $request->input('ticket_issued_to'),
        'departure_date' => $request->input('departure_date'),
        'return_date' => $request->input('return_date'),
        'airline_id' => $request->input('airline_id'),
        'base_fare' => $request->input('base_fare'),
        'taxes' => $request->input('taxes'),
        'amount_paid_to_airlines' => $request->input('amount_paid_to_airlines'),
        'amount_charged_from_pax' => $request->input('amount_charged_from_pax'),
        'status' => 'approved',
    ]);

    return redirect()->route('airtickets.index')
                     ->with('success', 'Air ticket added successfully.');
}
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,canceled,rejected',
    ]);

    $airTicket = AirTicket::findOrFail($id);
    $airTicket->status = $request->input('status');
    $airTicket->save();

    return redirect()->route('airtickets.index')
                     ->with('success', 'Status updated successfully.');
}
}
