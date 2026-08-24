<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AirlineDetail;
use App\Models\FlightDetail;
use App\Models\Reservation;
use App\Models\Pnr;
use App\Models\Admin;
use App\Models\AdminDetail;
use App\Models\Airline;


class ReservationController extends Controller
{
    public function newSale()
    {   
        $airlineDetails = AirlineDetail::where('deleted_at', NULL)->where('created_by', auth('admin')->user()->id)->with('airline')->get();
        $airlines = Airline::where('created_by', auth('admin')->user()->id)->get();
        return view('admin.reservations.new-sale', compact('airlineDetails', 'airlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_type' => 'required',
            'sale_type' => 'required',
            'sale_status' => 'required',
            'booking_ref' => 'required',
            'adult' => 'required|integer|min:0',
            'child' => 'required|integer|min:0',
            'infant' => 'required|integer|min:0',
            'date' => 'required|date',
            'airline_id' => 'required',
            'customer_type' => 'required',
            'purchased' => 'required',
            'service_charges' => 'required',
            'sold' => 'required',
            'flight_number' => 'required|array',
            'departure_city' => 'required|array',
            'arrival_city' => 'required|array',
            'flight_date' => 'required|array',
            'pnr_title' => 'required|array',
            'pnr_number' => 'required|array',
            'ticket_no' => 'required|array',
            'pax_first_name' => 'required|array',
            'pax_last_name' => 'required|array',
        ]);

        // Create multiple flight detail records
        $flightDetailIds = [];
        foreach ($request->flight_number as $index => $flightNumber) {
            $flightDetail = FlightDetail::create([
                'flight_number' => $flightNumber,
                'departure_city' => $request->departure_city[$index],
                'arrival_city' => $request->arrival_city[$index],
                'date' => $request->flight_date[$index],
                'created_by' => auth('admin')->user()->id,
            ]);
            $flightDetailIds[] = $flightDetail->id;
        }

        // Create multiple PNR records for passengers
        $pnrIds = [];
        foreach ($request->pnr_title as $index => $title) {
            $pnr = Pnr::create([
                'title' => $title,
                'pnr_number' => $request->pnr_number[$index],
                'ticket_no' => $request->ticket_no[$index],
                'pax_first_name' => $request->pax_first_name[$index],
                'pax_last_name' => $request->pax_last_name[$index],
                'created_by' => auth('admin')->user()->id,
            ]);
            $pnrIds[] = $pnr->id;
        }

        // Create reservation with flight detail IDs and PNR IDs
        Reservation::create([
            'account_type' => $request->account_type,
            'sale_type' => $request->sale_type,
            'sale_status' => $request->sale_status,
            'booking_ref' => $request->booking_ref,
            'adult' => $request->adult,
            'child' => $request->child,
            'infant' => $request->infant,
            'date' => $request->date,
            'airline_id' => $request->airline_id,
            'customer_type' => $request->customer_type,
            'purchased' => $request->purchased,
            'service_charges' => $request->service_charges,
            'sold' => $request->sold,
            'pnr_id' => json_encode($pnrIds), // Store all PNR IDs as JSON
            'flight_detail_id' => json_encode($flightDetailIds), // Store all flight detail IDs as JSON
            'remarks' => $request->remarks,
            'created_by' => auth('admin')->user()->id,
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully with ' . count($flightDetailIds) . ' flight details and ' . count($pnrIds) . ' passengers.');
    }
}
