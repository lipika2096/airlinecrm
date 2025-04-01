<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use App\Models\AirlineDetail;
use Illuminate\Http\Request;

class AirlineDetailController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        // Fetch airline details along with related airline information
        $airlineDetails = AirlineDetail::where('deleted_at',NULL)->where('created_by', auth('admin')->user()->id)->with('airline')->get();
        $airlines = Airline::all();
        return view('admin.airline-details', compact('airlineDetails', 'airlines'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'exists:airlines,id',
            'airline_ticketing_code' => 'string|max:255',
            'airline_contact_details' => 'string|max:255',
            'rules_do' => 'string|max:255',
            'rules_dont' => 'string|max:255',
            'standard_cancellation_charges' => 'string|max:255',
            'date_change_charges' => 'string|max:255',
            'routes_flown_from' => 'string|max:255',
            'routes_flown_to' => 'string|max:255',
        ]);

        AirlineDetail::create($request->all());

        return redirect()->route('admin.airlines-details')
            ->with('success', 'Airline detail created successfully.');
    }

    // Show the form for editing the specified resource
    public function edit(AirlineDetail $airlineDetail)
    {
        $airlines = Airline::all();
        return view('admin.airline-details.edit', compact('airlineDetail', 'airlines'));
    }

    // Update the specified resource in storage
    public function update(Request $request, AirlineDetail $airlineDetail)
    {
        $request->validate([
            'airline_id' => 'exists:airlines,id',
            'airline_ticketing_code' => 'string|max:255',
            'airline_contact_details' => 'string|max:255',
            'rules_do' => 'string|max:255',
            'rules_dont' => 'string|max:255',
            'standard_cancellation_charges' => 'string|max:255',
            'date_change_charges' => 'string|max:255',
            'routes_flown_from' => 'string|max:255',
            'routes_flown_to' => 'string|max:255',
        ]);

        $airlineDetail->update($request->all());

        return redirect()->route('admin.airlines-details')
            ->with('success', 'Airline detail updated successfully.');
    }

    public function destroy(AirlineDetail $airlineDetail)
    {
        try {
            $airlineDetail->delete();
            return redirect()->route('admin.airlines-details')
                ->with('success', 'Airline detail deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.airlines-details')
                ->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

}
