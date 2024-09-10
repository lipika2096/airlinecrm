<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Sector;

class FlightController extends Controller
{
    public function index()
    {
        $airlines = Airline::all();
        $sectors = Sector::all();
        $flights = Flight::all();

       $flights = Flight::with(['airline', 'origin', 'destination'])->get();

        return view('admin.flights', compact('flights', 'airlines', 'sectors'));
    }

    public function create()
    {
        $airlines = Airline::all();
        $sectors = Sector::all();
        return view('admin.flights.create', compact('airlines', 'sectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_no' => 'required|string|max:255',
            'flight_name' => 'required|string|max:255',
            'airline_id' => 'required|exists:airlines,id',
            'origin_id' => 'required|exists:sectors,id',
            'destination_id' => 'required|exists:sectors,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'available_seats' => 'required|integer',
        ]);

        Flight::create($request->all());

        return redirect()->route('admin.flights')
            ->with('success', 'Flight created successfully.');
    }

    public function edit(Flight $flight)
    {
        $airlines = Airline::all();
        $sectors = Sector::all();
        return view('admin.flights.edit', compact('flight', 'airlines', 'sectors'));
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'flight_no' => 'required|string|max:255',
            'flight_name' => 'required|string|max:255',
            'airline_id' => 'required|exists:airlines,id',
            'origin_id' => 'required|exists:sectors,id',
            'destination_id' => 'required|exists:sectors,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'available_seats' => 'required|integer',
        ]);

        $flight->update($request->all());

        return redirect()->route('admin.flights')
            ->with('success', 'Flight updated successfully.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()->route('admin.flights')
            ->with('success', 'Flight deleted successfully.');
    }
}
