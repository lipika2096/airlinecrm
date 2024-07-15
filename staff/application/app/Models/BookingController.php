<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $agentId = Auth::id(); // Get the logged-in agent's ID

        // Fetch cancelled bookings for the logged-in agent
        $bookings = Booking::where('agent_id', $agentId)
                           ->where('status', 'confirmed')
                           ->get();

        return view('bookings.cancel', compact('bookings'));
    }

    public function cancel()
    {
        $agentId = Auth::id(); // Get the logged-in agent's ID

        // Fetch cancelled bookings for the logged-in agent
        $bookings = Booking::where('agent_id', $agentId)
                           ->where('status', 'cancelled')
                           ->get();

        return view('bookings.cancel', compact('bookings'));
    }

    public function history()
    {

        $agentId = Auth::id(); // Get the logged-in agent's ID

        // Fetch all bookings for the logged-in agent
        $bookings = Booking::where('agent_id', $agentId)->get();

        return view('bookings.history', compact('bookings'));
    }


}
