<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::latest()->get();
        // Add your logic for calendar view
        return view('admin.airlines', compact('airlines')); // Example view path, adjust as per your structure
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'airline_code' => 'required|string|max:255|unique:airlines',
            'airline_name' => 'required|string|max:255',
            'airline_ticketing_code' => 'required|string|max:255|unique:airlines',
            'airline_contact_details' => 'required|string',
            'rules_do' => 'required|string',
            'rules_dont' => 'required|string',
            'standard_cancellation_charges' => 'required|string',
            'date_change_charges' => 'required|string',
            'routes_flown_from' => 'required|string',
            'routes_flown_to' => 'required|string',
        ]);

        // Create a new airline record
        $airline = Airline::create($validatedData);

        // Return a response
        return redirect()->route('admin.airlines')->with('success', 'Department added successfully');
    }

    /**
     * Update the specified airline in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'airline_code' => 'sometimes|required|string|max:255',
            'airline_name' => 'required|string|max:255',
            'airline_ticketing_code' => 'sometimes|required|string|max:255|unique:airlines,airline_ticketing_code,' . $id,
            'airline_contact_details' => 'sometimes|required|string',
            'rules_do' => 'sometimes|required|string',
            'rules_dont' => 'sometimes|required|string',
            'standard_cancellation_charges' => 'sometimes|required|string',
            'date_change_charges' => 'sometimes|required|string',
            'routes_flown_from' => 'sometimes|required|string',
            'routes_flown_to' => 'sometimes|required|string',
        ]);

        // Find the airline record
        $airline = Airline::findOrFail($id);

        // Update the airline record with validated data
        $airline->update($validatedData);

        // Return a response
        return redirect()->route('admin.airlines')->with('success', 'Department added successfully');
    }
}
