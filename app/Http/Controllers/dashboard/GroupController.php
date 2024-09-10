<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Client;
use App\Models\Agent;
use App\Models\User;
use App\Models\Airline;

class GroupController extends Controller
{
    public function index()
    {
        $group = Group::latest()->get();
        $agent = Agent::latest()->get();
        $airline = Airline::latest()->get();
        // Add your logic for calendar view
        return view('admin.groups', compact('group', 'agent', 'airline')); // Example view path, adjust as per your structure
    }
    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'airline_id' => 'required|integer', // Adjust validation as per your database schema
        'agent_id' => 'required|integer',   // Adjust validation as per your database schema
        // Add other fields as needed
    ]);

    // Create a new group record
    $group = Group::create($validatedData);

    // Return a response
    return redirect()->route('admin.groups')->with('success', 'Group added successfully');
}


    /**
     * Update the specified airline in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'airline_id' => 'sometimes|required|integer', // Adjust validation as per your database schema
        'agent_id' => 'sometimes|required|integer',   // Adjust validation as per your database schema
        // Add other fields as needed
    ]);

    // Find the group record
    $group = Group::findOrFail($id);

    // Update the group record with validated data
    $group->update($validatedData);

    // Return a response
    return redirect()->route('admin.groups')->with('success', 'Group updated successfully');
}

}
