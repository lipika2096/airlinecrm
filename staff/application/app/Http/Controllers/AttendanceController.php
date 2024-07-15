<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\Auth;
class AttendanceController extends Controller
{
    public function index()
    {
        // $agentId = Auth::id();
        // $airTickets = AirTicket::where('agent_id', $agentId)->get();
        return view('attendance.index');
    }
    public function punchIn(Request $request)
    {
        $attendance = new EmployeeAttendance();
        $attendance->employee_id = $request->employee_id;
        $attendance->punch_in = $request->time;
        $attendance->save();

        return response()->json(['success' => true]);
    }

    public function punchOut(Request $request)
    {
        $attendance = EmployeeAttendance::where('employee_id', $request->employee_id)
                                        ->whereNull('punch_out')
                                        ->orderBy('created_at', 'desc')
                                        ->first();
        if ($attendance) {
            $attendance->punch_out = $request->time;
            $attendance->save();
        }

        return response()->json(['success' => true]);
    }
}
