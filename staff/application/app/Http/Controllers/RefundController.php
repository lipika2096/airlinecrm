<?php

namespace App\Http\Controllers;
use App\Models\Refund;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{

    public function index()
    {
        $agentId = Auth::id();


        $refunds = Refund::where('agent_id', $agentId)->get();

        return view('refunds.index', compact('refunds'));
    }

    public function create()
    {
        $bookings = Booking::all();

        $users = User::where('role_id', 2)->get();
        return view('refunds.create', compact('bookings', 'users'));
    }


    public function store(Request $request)
    {
        // Comment out or remove the validation block for testing purposes
        // $request->validate([
        //     'booking_id' => 'required|exists:bookings,id',
        //     'passenger_id' => 'required|exists:users,id',
        //     'refund_amount' => 'required|numeric|min:0',
        //     'status' => 'required|in:pending,approved,rejected',
        //     'request_date' => 'required|date',
        //     'processed_date' => 'nullable|date',
        //     'reason' => 'nullable|string',
        // ]);

        $refund = new Refund();
        $refund->booking_id = $request->booking_id;
        $refund->passenger_id = $request->passenger_id;
        $refund->refund_amount = $request->refund_amount;
        $refund->refund_status = $request->refund_status;
        $refund->request_date = $request->request_date;
        $refund->processed_date = $request->processed_date;
        $refund->reason = $request->reason;
        $refund->agent_id = Auth::id(); // Assign the logged-in user's ID as agent_id
        $refund->save();

        return redirect()->route('refunds.index')->with('success', 'Refund created successfully.');
    }

    public function edit($id)
    {
        $bookings = Booking::all();

        $users = User::where('role_id', 2)->get();
        $refund = Refund::findOrFail($id);
        return view('refunds.edit', compact('refund', 'users', 'bookings'));
    }




    public function update(Request $request, $id)
{
    $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'passenger_id' => 'required|exists:users,id',
        'refund_amount' => 'required|numeric|min:0',
        'status' => 'required|in:pending,approved,rejected',
        'request_date' => 'required|date',
        'processed_date' => 'nullable|date',
        'reason' => 'nullable|string',
    ]);

    $refund = Refund::findOrFail($id);
    $refund->booking_id = $request->booking_id;
    $refund->passenger_id = $request->passenger_id;
    $refund->refund_amount = $request->refund_amount;
    $refund->status = $request->status;
    $refund->request_date = $request->request_date;
    $refund->processed_date = $request->processed_date;
    $refund->reason = $request->reason;
    // Ensure agent_id remains unchanged during update
    // $refund->agent_id = $refund->agent_id; // Uncomment this if agent_id should not be changed
    $refund->save();

    return redirect()->route('refunds.index')->with('success', 'Refund request updated successfully.');
}


    public function destroy($id)
    {
        $refund = Refund::findOrFail($id);
        $refund->delete();

        return redirect()->route('refunds.index')
            ->with('success', 'Refund request deleted successfully.');
    }
}
