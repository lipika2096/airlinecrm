<?php

namespace App\Http\Controllers;
use App\Models\Airline;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Commission;
class CommissionController extends Controller
{
    public function index()
{
    // Fetch all airlines
    $airlines = Airline::all();

    // Fetch agents where role_id is 2 (assuming role_id 2 corresponds to agents)
    $agents = User::where('role_id', 2)->get();

    // Fetch commissions where agent_id matches the authenticated user's id
    $authId = auth()->id(); // Assuming you are using Laravel's built-in authentication
    $commissions = Commission::with('airline', 'agent')
                    ->where('agent_id', $authId)
                    ->get();

    return view('commissions.index', compact('commissions', 'airlines', 'agents'));
}


    // public function create()
    // {
    //     $airlines = Airline::all();
    //     $agents = User::where('role_id', 2)->get();
    //     return view('commissions.create', compact('airlines', 'agents'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'market' => 'required|string',
    //         'commission_rate' => 'required|numeric',
    //         'provisions' => 'nullable|string',
    //         'airline_id' => 'required|exists:airlines,id',
    //         'agent_id' => 'required|exists:users,id',
    //         'status' => 'nullable|string',
    //     ]);

    //     Commission::create($request->all());

    //     return redirect()->route('commissions.index')
    //         ->with('success', 'Commission created successfully.');
    // }

    // public function edit(Commission $commission)
    // {
    //     $airlines = Airline::all();
    //     $agents = User::where('role_id', 2)->get();
    //     return view('commissions.edit', compact('commission', 'airlines', 'agents'));
    // }

    // public function update(Request $request, Commission $commission)
    // {
    //     $request->validate([
    //         'market' => 'required|string',
    //         'commission_rate' => 'required|numeric',
    //         'provisions' => 'nullable|string',
    //         'airline_id' => 'required|exists:airlines,id',
    //         'agent_id' => 'required|exists:users,id',
    //         'status' => 'nullable|string',
    //     ]);

    //     $commission->update($request->all());

    //     return redirect()->route('commissions.index')
    //         ->with('success', 'Commission updated successfully.');
    // }

    // public function destroy(Commission $commission)
    // {
    //     $commission->delete();

    //     return redirect()->route('commissions.index')
    //         ->with('success', 'Commission deleted successfully.');
    // }
}
