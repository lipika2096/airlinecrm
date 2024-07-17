<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Holiday;
use App\Models\EmployeeLeave;
use App\Models\Client;
use App\Models\User;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Calender;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function punchIn(Request $request)
    {
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        $attendance = new EmployeeAttendance();
        $attendance->employee_id = $employee->id;
        $attendance->punch_in = $request->time;
        $attendance->save();

        return response()->json(['success' => true]);
    }

    public function punchOut(Request $request)
    {
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        $attendance = EmployeeAttendance::where('employee_id',  $employee->id)
                                        ->whereNull('punch_out')
                                        ->orderBy('created_at', 'desc')
                                        ->first();
        if ($attendance) {
            $attendance->punch_out = $request->time;
            $attendance->save();
        }

        return response()->json(['success' => true]);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
          ]);
          $credentials = $request->only('email', 'password');
          // Attempt to log the user in
          if (Auth::guard('employee')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $admin = Auth::guard('employee')->user();
            $name = $admin->first_name ." ". $admin->last_name;
          $request->session()->put('employee_name', $name );
          $request->session()->put('email', $admin->email );
          $request->session()->put('role', 'Employee');

            return redirect()->route('employee.dashboard');
          }

          // If unsuccessful, then redirect back to the login with the form data
          // If unsuccessful, then redirect back to the login with the form data
          return redirect()
            ->back()
            ->with('error', 'These credentials do not match our records.');
    }
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout(); // Log the admin out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('employee.login'); // Redirect to the login page
    }
    public function allEmployees()
    {
        $employees = Employee::latest()->get();
        $department = Department::latest()->get();
        $designation = Designation::latest()->get();
        return view('admin.employees', compact('employees', 'department', 'designation')); // Example view path, adjust as per your structure
    }

    public function Employeeslist()
    {
        // Add your logic for listing all employees
        return view('admin.employees-list'); // Example view path, adjust as per your structure
    }

    public function store(Request $request)
    {
        // // Validate the request
        // $request->validate([
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'nullable|string|max:255',
        //     'username' => 'required|string|max:255|unique:employees,username',
        //     'email' => 'required|string|email|max:255|unique:employees,email',
        //     'password' => 'required|string|min:8|',
        //     'employee_id' => 'required|string|max:255|unique:employees,employee_id',
        //     'phone' => 'nullable|string|max:255',
        //     'department' => 'required|string|max:255',
        //     'designation' => 'required|string|max:255',
        //     // Add validation for permissions if needed
        // ]);
        // Create a new employee
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->employee_id = $request->employee_id;
        $employee->joining_date = $request->joining_date;
        $employee->phone = $request->phone;
        $employee->department_id = $request->department;
        $employee->designation_id = $request->designation;
        $employee->leave_count = $request->input('leave_count');

        $employee->save();

        return redirect()->route('admin.employees')->with('success', 'Employee added successfully');
    }
    public function edit(Request $request, $id)
    {
        // // Handle image upload
        // $image = $request->file('image');
        // $imageName = null;
        // if ($image) {
        //     $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        //     $imagePath = $image->move('pubilc/assets/upload', $imageName);
        //     if (!$imagePath) {
        //         return back()->with('error', 'Failed to upload image');
        //     }
        // }

        // Create a new employee
        $employee =  Employee::find($id);
        $employee->update([
            'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'employee_id' => $request->input('employee_id'),
        'joining_date' => $request->input('joining_date'),
        'phone' => $request->input('phone'),
        'department' => $request->input('department'),
        'designation' => $request->input('designation')
        ]);
        return redirect()->route('admin.employees')->with('success', 'Employee added successfully');
    }

    public function viewEmployeeProfile(Request $request, $id){
        $employeeProfile = Employee::find($id);
        return view('admin.employee-profile', compact('employeeProfile'));
    }

    public function holidays()
    {
        $holidays = Holiday::latest()->get();
        // Add your logic for holidays view
        return view('admin.holidays',compact('holidays')); // Example view path, adjust as per your structure
    }
    public function holidayStore(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required',
            'holiday_date' => 'required',
            // Add validation for permissions if needed
        ]);
        $holidayDate = $request->input('holiday_date');
        $holidayDay = Carbon::parse($holidayDate)->format('l');
        // Create a new employee
        Holiday::create([
            'title' => $request->input('title'),
            'holiday_date' => $request->input('holiday_date'),
            'holiday_day' => $holidayDay,
            'category' => $request->input('category')
            ]);

        $holidays = Holiday::latest()->get();
        // Add your logic for holidays view
        return redirect()->route('admin.holidays');
    }
    public function holidayUpdate(Request $request , $id)
    {
        // Create a new employee
        $holiday =  Holiday::find($id);
        $holiday->update([
            'title' => $request->input('title'),
            'holiday_date' => $request->input('holiday_date'),
            'holiday_day' => $request->input('holiday_day'),
            'category' => $request->input('category')
        ]);
        $holidays = Holiday::latest()->get();
        // Add your logic for holidays view
        return redirect()->route('admin.holidays');
    }

    public function leavesAdmin()
    {
        $total_employee = Employee::count();
        $employees = Employee::latest()->get();
        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
                                                 ->whereDate('to', '>=', now()->toDateString())->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)->count();
        //$employee_leaves = EmployeeLeave::latest()->get();
        $employee_leaves = EmployeeLeave::latest()->get();
        // Number of employees on leave today
        $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
                                                 ->whereDate('to', '>=', now()->toDateString())
                                                 ->count();
        // Number of present employees today
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;
        // Add your logic for leaves admin view
        return view('admin.leaves', compact('total_employee','employees','total_pending_leaves','total_leaves','employee_leaves','noofpresentemployeestoday')); // Example view path, adjust as per your structure
    }

    public function leavesAdminStore(Request $request)
    {
        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'reason' => $request->input('reason'),
            'status' => 1
            ]);
        // Add your logic for leaves admin view
        return redirect()->route('admin.leaves')->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leavesAdminUpdate(Request $request, $id)
    {
        $leaves =  EmployeeLeave::find($id);
        $leaves->update([
            'status' => $request->input('status')
        ]);
        // Add your logic for leaves admin view
        return redirect()->route('admin.leaves')->with('success', 'Employee added successfully');
    }

    public function leavesEmployee()
    {
        // Add your logic for leaves employee view
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        $total_leaves = Employee::where('id',$employee->id)->pluck('leave_count')->first();
        $medical_leave = EmployeeLeave::where('employee_id',$employee->id)->where('leave_type','Medical Leave')->count();
        $other_leave = EmployeeLeave::where('employee_id', $employee->id)
        ->where('leave_type', '!=', 'Medical Leave')
        ->count();
        $total_taken = EmployeeLeave::where('employee_id',$employee->id)->count();
        $remaining_leave = $total_leaves - $total_taken;
        $leaves = EmployeeLeave::where('employee_id',$employee->id)->get();
        return view('admin.leaves-employee', compact('total_leaves', 'medical_leave', 'other_leave', 'remaining_leave','leaves')); // Example view path, adjust as per your structure
    }
    public function leavesEmployeeStore(Request $request)
    {
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        EmployeeLeave::create([
            'employee_id' => $employee->id,
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'reason' => $request->input('reason'),
            'status' => 1
            ]);
        // Add your logic for leaves admin view
        return redirect()->route('employee.leaves')->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leaveSettings()
    {
        // Add your logic for leave settings view
        return view('admin.leave-settings'); // Example view path, adjust as per your structure
    }

    public function attendanceAdmin()
    {
         $attendance = DB::table('employee_attendances')
        ->select('employee_id', DB::raw('DATE(punch_in) as punch_date'))
        ->distinct()
        ->get()
        ->groupBy('employee_id');

// Fetch employee data to include in the view
$employees = Employee::get();
        // Add your logic for attendance admin view
        return view('admin.attendance', compact('attendance', 'employees'));
    }

    public function attendanceEmployee()
    {
        // Add your logic for attendance employee view
        return view('admin.attendance-employee'); // Example view path, adjust as per your structure
    }
    public function storeDepartment(Request $request)
    {
        // Validate the request
        $request->validate([
            'department_name' => 'required|string|max:255',
            // Add validation for permissions if needed
        ]);
        // Create a new employee
        $department = new Department();
        $department->department_name = $request->department_name;

        $department->save();

        return redirect()->route('admin.departments')->with('success', 'Employee added successfully');
    }
    public function editDepartment(Request $request, $id)
    {
        // Create a new employee
        $department =  Department::find($id);
        $department->update([
            'department_name' => $request->input('department_name'),
        ]);
        return redirect()->route('admin.departments')->with('success', 'Department added successfully');
    }
    public function departments()
    {
        // Add your logic for departments view
        $department = Department::latest()->get();
        return view('admin.departments', compact('department')); // Example view path, adjust as per your structure
    }
    public function storeDesignation(Request $request)
    {
        // Validate the request
        $request->validate([
            'designation' => 'required|string|max:255',
            // Add validation for permissions if needed
        ]);
        // Create a new employee
        $department = new Designation();
        $department->department_id = $request->department;
        $department->designation = $request->designation;

        $department->save();

        return redirect()->route('admin.designations')->with('success', 'Employee added successfully');
    }
    public function editDesignation(Request $request, $id)
    {
        // Create a new employee
        $designation =  Designation::find($id);

        $designation->update([
            'department_id' => $request->input('department'),
            'designation' => $request->input('designation'),
        ]);
        return redirect()->route('admin.designations')->with('success', 'Department added successfully');
    }

    public function designations()
    {
        $department = Department::latest()->get();
        $designation = Designation::latest()->get();
        // Add your logic for designations view
        return view('admin.designations', compact('designation', 'department')); // Example view path, adjust as per your structure
    }

    public function timesheet()
    {
        // Add your logic for timesheet view
        return view('admin.timesheet'); // Example view path, adjust as per your structure
    }

    public function shiftScheduling()
    {
        // Add your logic for shift scheduling view
        return view('admin.shift-scheduling'); // Example view path, adjust as per your structure
    }

    public function overtime()
    {
        // Add your logic for overtime view
        return view('admin.overtime'); // Example view path, adjust as per your structure
    }
}
