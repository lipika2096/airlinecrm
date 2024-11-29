<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Validator;

class LeaveTypeController extends Controller
{
    public function leaveType()
    {
        $leaves = LeaveType::all();
        return view('admin.leave-type', compact('leaves'));
    }

    public function storeLeaveType(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'days' => 'required|integer'
        ]);

        $leave = new LeaveType();
        $leave->name = $request->name;
        $leave->days = $request->days;
        $leave->save();

        return redirect()->route('admin.leave-type')->with('success', 'Leave Type created successfully.');
    }

    public function updateLeaveType(Request $request, $id)
    {
        $leave = LeaveType::findorFail($id);
        $leave->name = $request->name;
        $leave->days = $request->days;
        $leave->save();

        return redirect()->route('admin.leave-type')->with('success', 'Leave Type updated successfully.');
    }

    public function deleteLeaveType(Request $request, $id){
        $leave = LeaveType::find($id);
        $leave->delete();
        return redirect()->route('admin.leave-type')->with('success', 'Leave Type updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $leave = LeaveType::find($request->id);
        if ($leave) {
            $leave->status = $request->status;
            $leave->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Leave Type not found.'], 404);
    }

}
