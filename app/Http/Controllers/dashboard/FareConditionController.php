<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\FareCondition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class FareConditionController extends Controller
{
    public function index()
    {
        // Fetch all fare conditions with the related agent data
        $fareConditions = FareCondition::with('agent')->get();
        return view('admin.fare_conditions.index', compact('fareConditions'));
    }

    public function create()
    {
        // Fetch agents where role is 2
        $agents = User::where('role_id', 2)->get();
        return view('admin.fare_conditions.create', compact('agents'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fare_condition_details' => 'required',
            'cancellation_policy' => 'required',
            'date_change_policy' => 'required',
            'effective_from_date' => 'required|date',
            'valid_till_date' => 'required|date'

        ]);

        // Create FareCondition with agent_id included
        FareCondition::create([
            'fare_condition_details' => $request->fare_condition_details,
            'cancellation_policy' => $request->cancellation_policy,
            'date_change_policy' => $request->date_change_policy,
            'updated_by' => Auth::id(),
            'agent_id' => $request->agent_id,
            'effective_from_date' => $request->effective_from_date,
            'valid_till_date' => $request->valid_till_date,
        ]);

        return redirect()->route('admin.fare_conditions.index')
            ->with('success', 'Fare Condition created successfully.');
    }



    public function edit(FareCondition $fareCondition)
{


    // Fetch agents where role is 2
    $agents = User::where('role_id', 2)->get();
    return view('admin.fare_conditions.edit', compact('fareCondition', 'agents'));
}

    public function update(Request $request, FareCondition $fareCondition)
    {
        $request->validate([
            'fare_condition_details' => 'required',
            'cancellation_policy' => 'required',
            'date_change_policy' => 'required',
            'updated_by' => 'required',
            'effective_from_date' => 'required|date',
            'valid_till_date' => 'required|date',
        ]);

        $fareCondition->update($request->all());

        return redirect()->route('fare_conditions.index')
            ->with('success', 'Fare Condition updated successfully.');
    }

    public function destroy(FareCondition $fareCondition)
    {
        $fareCondition->delete();

        return redirect()->route('admin.fare_conditions.index')
            ->with('success', 'Fare Condition deleted successfully.');
    }
}
