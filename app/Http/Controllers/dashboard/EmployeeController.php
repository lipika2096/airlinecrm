<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\DepartmentRight;
use App\Models\Designation;
use App\Models\Holiday;
use App\Models\EmployeeLeave;
use App\Models\Client;
use App\Models\User;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Calender;
use App\Models\LeaveType;
use Carbon\Carbon;

use App\Models\Duty;
use App\Models\SpecialFare;


use App\Models\FareType;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{

    public function PemployeeProfile($id){
        $employees = User::find($id);
        return view('admin.view-profile', compact('employees'));
    }

    public function viewUserProfile(){
        $employees = User::where('role_id', 2)->get();
         $department = Department::latest()->get();
        $designation = Designation::latest()->get();

        return view('admin.view-employee', compact('employees','department', 'designation'));
    }

    public function storeUserProfile(Request $request) {

        // Create a new client record
        $client = new Client();
        $client->client_creatorid = 0;
        $client->client_categoryid = 2;
        $client->client_created_from_leadid = 0;
        $client->client_company_name = "CRM";
        $client->save();

        // Create a new user record
        $user = new User();
        $user->clientid = $client->client_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->unique_id = $request->employee_id;
        $user->phone = $request->phone;
        $user->joining_date = $request->joining_date;
        $user->leave_count = $request->leave_count;
        $user->department = $request->department;
        $user->position = $request->designation;
        $user->account_owner = 'yes';
        $user->primary_admin = 'no';
        $user->type = 'client';
        $user->min_hrs = $request->min_hrs; // Set min_hrs
        $user->max_hrs = $request->max_hrs; // Set max_hrs
        $user->personal_phone = $request->phone;
        $user->dob = $request->joining_date;
        $user->work_type = $request->work_type;
        $user->branch = $request->branch;
        $user->company_mobile = $request->company_mobile;
        $user->save();

        return redirect()->back()->with('success', 'Employee added successfully');
    }


    public function updateUserProfile(Request $request, $id)
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
        $employee =  User::find($id);
        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'unique_id' => $request->input('employee_id'),
            'joining_date' => $request->input('joining_date'),
            'phone' => $request->input('phone'),
            'department' => $request->input('department'),
            'position' => $request->input('designation'),
            'min_hrs' => $request->input('min_hrs'),
            'max_hrs' => $request->input('max_hrs'),
            'personal_phone' => $request->input('personal_phone'),
            'company_mobile' => $request->input('company_mobile'),
            'branch' => $request->input('branch'),
            'work_type' => $request->input('work_type'),
            'dob' => $request->input('dob')
        ]);
        return redirect()->back()->with('success', 'Employee added successfully');
    }

    public function viewUserRights(){
        $department_rights = DepartmentRight::get();
         $department = Department::latest()->get();
        $duties = Duty::latest()->get();

        $specialFare = SpecialFare::where('agent_id', 4)->get();

        $fareType = FareType::get();


        return view('admin.view-rights', compact('department_rights', 'department','duties'));
    }

    public function storeUserRights(Request $request) {

        foreach ($request->input('department') as $departmentId => $duty) {
        foreach ($duty as $dutiesData => $status) {

            DepartmentRight::updateOrCreate(
                [
                    'staff_id' => $request->input('staff_id'),
                    'duties_id' => $dutiesData,
                    'department_id' => $departmentId
                ],
                [
                    'status' => $status
                ]
            );
        }
    }
        return redirect()->back()->with('success', 'User Rights by department added successfully');
    }


    // public function updateUserRights(Request $request, $id)
    // {
    //     // // Handle image upload
    //     // $image = $request->file('image');
    //     // $imageName = null;
    //     // if ($image) {
    //     //     $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
    //     //     $imagePath = $image->move('pubilc/assets/upload', $imageName);
    //     //     if (!$imagePath) {
    //     //         return back()->with('error', 'Failed to upload image');
    //     //     }
    //     // }

    //     // Create a new employee
    //     $rights =  DepartmentRight::find($id);
    //     $rights->update([
    //          'view_accounts' => $request->input('view_accounts'),
    //         'view_sales_leads' => $request->input('view_sales_leads'),
    //         'approve_holidays' => $request->input('approve_holidays'),
    //         'approve_overtime' => $request->input('approve_overtime'),
    //         ]);
    //     return redirect()->back()->with('success', 'Employee added successfully');
    // }

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

    public function allEmployees(Request $request)
    {

        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')->where('users.role_id', 2)
                        ->get(['clients.*', 'users.*']);
        $department = Department::latest()->get();
        $designation = Designation::latest()->get();

        $departmentEmployees = User::where('role_id', 2)->groupBy('department')->get();

        return view('admin.employees', compact('employees', 'department', 'designation','departmentEmployees'));
    }

    // Display the employee's details and leave information

    public function viewEmployee($id)
    {
        $employee = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.id', $id)
            ->first(['clients.*', 'users.*']);

        $employees = User::find($id);

        $currentDate = \Carbon\Carbon::now()->format('l, j.n.Y');

        $total_leave_taken = EmployeeLeave::where('employee_id', $id)
            ->where('status', 1)
            ->get()
            ->sum(function ($leave) {
                return \Carbon\Carbon::parse($leave->from)->diffInDays(\Carbon\Carbon::parse($leave->to)) + 1;
            });

            $tl = EmployeeLeave::where('employee_id',$id)->sum('no_of_days');
            $eel = User::where('id',$id)->first();

        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
        ->whereDate('to', '>=', now()->toDateString())->count();

        $approvedLeaves = EmployeeLeave::where('status', 3)->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)->count();
        $total_declined_leaves = EmployeeLeave::where('status', 4)->count();

        $remaining_leaves = $eel->leave_count-$approvedLeaves;
        $leave_used_percentage = ($total_leaves > 0) ? ($total_leave_taken / $total_leaves) * 100 : 0;
        $leave_used_percentage = min(100, max(0, $leave_used_percentage));

        $absent_colleagues = EmployeeLeave::whereDate('from', '<=', \Carbon\Carbon::today()->toDateString())
            ->whereDate('to', '>=', \Carbon\Carbon::today()->toDateString())
            ->get();

        $approvedLeaves = EmployeeLeave::where('status', 3)->count();
        $total_min_hrs = User::where('id', $id)->pluck('min_hrs')->first();
        $total_max_hrs = User::where('id', $id)->pluck('max_hrs')->first();
        $total_overtime = $total_max_hrs - $total_min_hrs;

        $total_employee = Client::count();

          $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
                                                     ->whereDate('to', '>=', now()->toDateString())
                                                     ->count();
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;

        // Calculate approved leaves for the current month
        $absencePerMonth = EmployeeLeave::where('employee_id', $id)
            ->where('status', 3) // Approved status
            ->whereMonth('from', now()->month)
            ->whereYear('from', now()->year)
            ->count();

        $leavetypes = LeaveType::all();
        $employee_leaves_view = EmployeeLeave::where('employee_id',$id)->latest()->get();
        return view('admin.view-profile', compact(
            'employee',
            'employees',
            'currentDate',
            'total_leave_taken',
            'remaining_leaves',
            'total_leaves',
            'tl',
            'leave_used_percentage',
            'absent_colleagues',
            'total_pending_leaves',
            'total_declined_leaves',
            'approvedLeaves',
            'total_overtime',
            'id',
            'noofpresentemployeestoday',
            'total_employee',
            'absencePerMonth',
            'leavetypes',
            'employee_leaves_view'
        ));
    }

// Store the employee's leave request
public function leavesStaffStore(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:users,id',
        'leave_type' => 'required|string',
        'from' => 'required|date',
        'to' => 'required|date|after_or_equal:from',
        'reason' => 'nullable|string',
    ]);

    EmployeeLeave::create([
        'employee_id' => $request->input('employee_id'),
        'leave_type' => $request->input('leave_type'),
        'from' => $request->input('from'),
        'to' => $request->input('to'),
        'reason' => $request->input('reason'),
        'status' => 1
    ]);

    return redirect()->route('admin.view-staff', ['id' => $request->input('employee_id')]);
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
        // $employee = new Employee();
        // $employee->first_name = $request->first_name;
        // $employee->last_name = $request->last_name;
        // $employee->email = $request->email;
        // $employee->password = Hash::make($request->password);
        // $employee->employee_id = $request->employee_id;
        // $employee->joining_date = $request->joining_date;
        // $employee->phone = $request->phone;
        // $employee->department_id = $request->department;
        // $employee->designation_id = $request->designation;
        // $employee->leave_count = $request->input('leave_count');

        // $employee->save();

        // Create a new client record
        $client = new Client();
        $client->client_creatorid = 0;
        $client->client_categoryid = 2;
        $client->client_created_from_leadid = 0;
        $client->client_company_name = "CRM";
        $client->save();

        // Create a new user record
        $user = new User();
        $user->clientid = $client->client_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->unique_id = $request->employee_id;
        $user->phone = $request->phone;
        $user->joining_date = $request->joining_date;
        $user->leave_count = $request->leave_count;
        $user->department = $request->department;
        $user->position = $request->designation;
        $user->account_owner = 'yes';
        $user->primary_admin = 'no';
        $user->type = 'client';
        $user->min_hrs = $request->min_hrs; // Set min_hrs
        $user->max_hrs = $request->max_hrs; // Set max_hrs
        $user->personal_phone = $request->phone;
        $user->dob = $request->joining_date;
        $user->work_type = $request->work_type;
        $user->branch = $request->branch;
        $user->company_mobile = $request->company_mobile;

        // // Handle image uploadsrc="{{ asset('staff/storage/avatars/'.$agent->avatar_directory."/" . $agent->avatar_filename) }}"
        // if ($request->hasFile('avatar_filename')) {
        //     $image = $request->file('avatar_filename');
        //     $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
        //     $directory = "NJj0UmpChhzd3BkXrQlWlACfoeecqzlerZgdR5rs";
        //     $imagePath = $image->move('staff/storage/avatars/NJj0UmpChhzd3BkXrQlWlACfoeecqzlerZgdR5rs/', $imageName);
        //     $user->avatar_filename = $imageName;
        // }

        $user->save();

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
        $employee =  User::find($id);
        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'unique_id' => $request->input('employee_id'),
            'joining_date' => $request->input('joining_date'),
            'phone' => $request->input('phone'),
            'department' => $request->input('department'),
            'position' => $request->input('designation'),
            'min_hrs' => $request->input('min_hrs'),
            'max_hrs' => $request->input('max_hrs'),
            'personal_phone' => $request->input('personal_phone'),
            'company_mobile' => $request->input('company_mobile'),
            'branch' => $request->input('branch'),
            'work_type' => $request->input('work_type'),
            'dob' => $request->input('dob')
        ]);
        return redirect()->route('admin.employees')->with('success', 'Employee added successfully');
    }

    public function destroy($id)
    {
        try {
            // Find the user based on the provided ID
            $user = User::findOrFail($id);

            // Find the client associated with this user
            $client = Client::where('client_id', $user->clientid)->first();

            // Delete the user and client records
            if ($user) {
                $user->delete();
            }

            if ($client) {
                $client->delete();
            }

            return redirect()->route('admin.employees')
                ->with('success', 'Employee and associated client deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.employees')
                ->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function manageStaff()
    {
        // Reuse the existing logic to fetch employees
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
                            ->where('users.role_id', 2)
                            ->get(['clients.*', 'users.*']);

        $department = Department::latest()->get();
        $designation = Designation::latest()->get();
        $total_employee = Client::count();
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

        // Return the view with the same data
        return view('admin.manage-staff', compact('employees', 'department', 'designation','total_employee', 'total_leaves', 'total_pending_leaves','total_leaves','employee_leaves','noofpresentemployeestoday'));
    }


    public function viewEmployeeProfile(Request $request, $id){
        $employeeProfile = Employee::find($id);
        return view('admin.employee-profile', compact('employeeProfile'));
    }

   public function holidays()
    {


        $holidays = Holiday::latest()->get();
        $total_employee = Client::count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->get(['clients.*', 'users.*']);
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

        $leavetypes = LeaveType::all();
        // Add your logic for leaves admin view
        return view('admin.holidays', compact('total_employee','employees','total_pending_leaves','total_leaves','employee_leaves','noofpresentemployeestoday', 'holidays', 'leavetypes')); // Example view path, adjust as per your structure


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
        $total_employee = Client::count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->get(['clients.*', 'users.*']);
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
        return redirect()->route('admin.holidays')->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leavesAdminUpdate(Request $request, $id)
    {
        $leaves =  EmployeeLeave::find($id);
        $leaves->update([
            'status' => $request->input('status')
        ]);
        // Add your logic for leaves admin view
        return redirect()->route('admin.holidays')->with('success', 'Employee added successfully');
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

    public function leavesEmployeeViewStore(Request $request)
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
        return redirect()->back()->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leavesEmployeeViewUpdate(Request $request, $id)
    {
        $leaves =  EmployeeLeave::find($id);
        $leaves->update([
            'status' => $request->input('status')
        ]);
        // Add your logic for leaves admin view
        return redirect()->back()->with('success', 'Employee added successfully');
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
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->get(['clients.*', 'users.*']);
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
