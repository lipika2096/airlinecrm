<?php

namespace App\Http\Controllers;
use App\Models\FareCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FareConditionController extends Controller
{


    public function index()
    {



        $authId = auth()->id(); // Assuming you are using Laravel's built-in authentication
        $fareConditions = FareCondition::where('agent_id', $authId)
                        ->get();

        return view('fare_conditions.index', compact('fareConditions'));
    }



    // public function create()
    // {
    //     return view('fare_conditions.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'fare_condition_details' => 'required',
    //         'cancellation_policy' => 'required',
    //         'date_change_policy' => 'required',
    //         'effective_from_date' => 'required|date',
    //         'valid_till_date' => 'required|date',
    //     ]);

    //     // Get authenticated user's agent_id
    //     $agentId = Auth::user()->agent_id;

    //     // Create FareCondition with agent_id included
    //     FareCondition::create([
    //         'fare_condition_details' => $request->fare_condition_details,
    //         'cancellation_policy' => $request->cancellation_policy,
    //         'date_change_policy' => $request->date_change_policy,
    //         'updated_by' => $agentId,
    //         'agent_id' => $agentId,// Assigning agent_id here
    //         'effective_from_date' => $request->effective_from_date,
    //         'valid_till_date' => $request->valid_till_date,
    //     ]);

    //     return redirect()->route('fare_conditions.index')
    //         ->with('success', 'Fare Condition created successfully.');
    // }

    // public function edit(FareCondition $fareCondition)
    // {
    //     return view('fare_conditions.edit', compact('fareCondition'));
    // }

    // public function update(Request $request, FareCondition $fareCondition)
    // {
    //     $request->validate([
    //         'fare_condition_details' => 'required',
    //         'cancellation_policy' => 'required',
    //         'date_change_policy' => 'required',
    //         'updated_by' => 'required',
    //         'effective_from_date' => 'required|date',
    //         'valid_till_date' => 'required|date',
    //     ]);

    //     $fareCondition->update($request->all());

    //     return redirect()->route('fare_conditions.index')
    //         ->with('success', 'Fare Condition updated successfully.');
    // }

    // public function destroy(FareCondition $fareCondition)
    // {
    //     $fareCondition->delete();

    //     return redirect()->route('fare_conditions.index')
    //         ->with('success', 'Fare Condition deleted successfully.');
    // }
}
