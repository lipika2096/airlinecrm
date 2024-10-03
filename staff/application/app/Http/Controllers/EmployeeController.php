<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Holiday;
use App\Models\EmployeeLeave;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function leavesEmployeeStore(Request $request)
				{

					$request->validate([
						'leave_type' => 'required|string',
						'from' => 'required|date',
						'to' => 'required|date|after_or_equal:from',
						'reason' => 'required|string',
					]);


					$employee = auth()->user();


					EmployeeLeave::create([
						'employee_id' => $employee->id,
						'leave_type' => $request->input('leave_type'),
						'from' => $request->input('from'),
						'to' => $request->input('to'),
						'no_of_days' => $request->input('no_of_days'),
						'reason' => $request->input('reason'),
						'status' => 1 // Default status
					]);

					return redirect()->back()->with('success', 'Leave submitted successfully');
				}
    public function leavesEmployee()
    {
        $authId = auth()->id();

        $annualLeave = 12;

        $medicalLeave = EmployeeLeave::where('employee_id', $authId)
                                     ->where('leave_type', 'Medical Leave')
                                     ->count();

        $otherLeave = EmployeeLeave::where('employee_id', $authId)
                                   ->whereNotIn('leave_type', ['Medical Leave'])
                                   ->count();

        $usedAnnualLeave = EmployeeLeave::where('employee_id', $authId)

                                        ->count();
        $remainingLeave = $annualLeave - $usedAnnualLeave;

        $total_employee = Employee::count();
        $employees = Employee::latest()->get();
        $total_leaves = EmployeeLeave::where('created_at', now()->toDateString())
                                     ->where('employee_id', $authId)
                                     ->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)
                                             ->where('employee_id', $authId)
                                             ->count();
        $employee_leaves = EmployeeLeave::where('employee_id', $authId)->latest()->get();



        return view('leaves.index', compact(
            'total_employee',
            'employees',
            'total_pending_leaves',
            'total_leaves',
            'employee_leaves',
            'annualLeave',
            'medicalLeave',
            'otherLeave',
            'remainingLeave'
        ));

    }


    public function create()
    {
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $leave = new EmployeeLeave();
        $leave->employee_id = auth()->id();
        $leave->leave_type = $request->input('leave_type');
        $leave->from = $request->input('from');
        $leave->to = $request->input('to');
        $leave->no_of_days = $this->calculateNumberOfDays($request->input('from'), $request->input('to'));
        $leave->reason = $request->input('reason');
        $leave->status = 1; // New leave status
        $leave->save();

        return redirect()->route('leaves-employee')->with('success', 'Leave added successfully.');
    }

    private function calculateNumberOfDays($fromDate, $toDate)
    {
        $start = new \DateTime($fromDate);
        $end = new \DateTime($toDate);
        $interval = $start->diff($end);
        return $interval->days + 1; // Include both start and end dates
    }
 public function attendanceEmployee()
 {
     // Add your logic for attendance employee view
     return view('attendance.index'); // Example view path, adjust as per your structure
 }

 public function punchIn(Request $request)
 {
     $attendance = new Attendance();
     $attendance->employee_id = auth()->user()->id;
     $attendance->punch_in = now()->format('Y-m-d H:i:s');
     $attendance->save();

     return response()->json(['message' => 'Punched in successfully']);
 }

 public function punchOut(Request $request)
 {
     $attendance = Attendance::where('employee_id', auth()->user()->id)
         ->whereNull('punch_out')
         ->latest()
         ->first();

     if ($attendance) {
         $attendance->punch_out = now()->format('Y-m-d H:i:s');
         $attendance->save();
         return response()->json(['message' => 'Punched out successfully']);
     }

     return response()->json(['message' => 'No active punch-in found']);
 }

 public function fetchAttendance(Request $request)
 {
     $attendances = Attendance::where('employee_id', auth()->user()->id)
         ->orderBy('created_at', 'desc')
         ->get();

     return response()->json(['attendances' => $attendances]);
 }

}
