<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\AirTicket;

class AirTicketController extends Controller
{
    public function index()
    {
        $tickets = AirTicket::latest()->get();
        // Add your logic for calendar view
        return view('admin.airticket', compact('tickets')); // Example view path, adjust as per your structure
    }

}
