<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;

class WalletController extends Controller
{
    /**
     * Display a listing of the wallets.
     */
    public function index()
    {
        $agents = User::whereHas('wallets')
            ->with(['wallets' => function ($query) {
                $query->select('id', 'agent_id', 'wallet', 'available_balance', 'razorpay_id', 'status', 'parent_id', 'description', 'date');
            }])
            ->get()
            ->map(function ($agent) {
                $agent->total_wallet = $agent->wallets->sum('wallet');
                return $agent;
            });

        $eligibleAgents = User::where('role_id', 2)->get();

        return view('admin.wallet', compact('agents', 'eligibleAgents'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'agent_id' => 'required|exists:users,id,role_id,2',
            'wallet' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        try {
            // Create a new wallet entry
            $wallet = new Wallet();
            $wallet->agent_id = $request->agent_id;
            $wallet->wallet = $request->wallet;
            $wallet->description = $request->description;
            $wallet->date = $request->date;
            $wallet->save();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Wallet entry added successfully.');
        } catch (\Exception $e) {
            // Handle any errors that occur during saving
            return redirect()->back()->with('error', 'Failed to add wallet entry. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified wallet.
     */
    public function show($id)
    {
        $wallet = Wallet::findOrFail($id);
        return response()->json($wallet);
    }

    /**
     * Update the specified wallet in storage.
     */
    public function update(Request $request, $id)
    {
        $wallet = Wallet::findOrFail($id);

        $validatedData = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'wallet' => 'required|numeric',

            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $wallet->update($validatedData);

        return response()->json($wallet);
    }

    /**
     * Remove the specified wallet from storage.
     */
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return response()->json(null, 204);
    }
}
