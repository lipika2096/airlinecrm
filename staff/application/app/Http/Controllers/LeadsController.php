<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadModal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadsController extends Controller
{
    public function index()
    {
        $leads = LeadModal::all(); // Fetch all leads

        return view('salelead.index', compact('leads'));
    }

    public function create()
    {
        return view('salelead.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'project' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $lead = new LeadModal();

        // Assign values from the request
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->phone = $request->input('phone');
        $lead->project = $request->input('project');
        $lead->company = $request->input('company');

        // Save the lead
        $lead->save();

        // Redirect to index page with success message
        return redirect()->route('saleleads.indexa')->with('success', 'Lead added successfully.');
    }




    public function edit($id)
    {
        $lead = LeadModal::findOrFail($id);
        return view('salelead.edit', compact('lead'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'project' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Find the lead by ID
        $lead = LeadModal::findOrFail($id);

        // Update lead fields
        $lead->name = $request->input('name');
        $lead->email = $request->input('email');
        $lead->phone = $request->input('phone');
        $lead->project = $request->input('project');
        $lead->company = $request->input('company');

        // Save the updated lead
        $lead->save();

        // Redirect to index page with success message
        return redirect()->route('saleleads.indexa')->with('success', 'Lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = LeadModal::findOrFail($id);
        $lead->delete();

        return redirect()->route('salelead.index')->with('success', 'Lead deleted successfully.');
    }

    public function show()
    {
        $agentId = Auth::id();
        $agent = User::findOrFail($agentId); // Assuming you have a User model
        return view('user.view', compact('agent'));
    }
}
