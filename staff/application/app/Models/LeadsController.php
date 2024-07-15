<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadModal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller
{
    public function index()
    {
        $leads = LeadModal::all(); // Fetch all leads

        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $lead = new LeadModal();
        // Fill the lead model with request data
        $lead->fill($request->all());
        $lead->lead_created = now(); // Set created timestamp or your desired date format

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function editLead($id)
    {
        $lead = LeadModal::findOrFail($id);
        return view('leads.edit', compact('lead'));
    }

    public function updateLead(Request $request, $id)
    {
        $lead = LeadModal::findOrFail($id);
        $lead->fill($request->all());

        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = LeadModal::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function show()
    {
        $agentId = Auth::id();
        $agent = User::findOrFail($agentId); // Assuming you have a User model
        return view('user.view', compact('agent'));
    }
}
