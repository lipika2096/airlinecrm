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
use App\Models\StaffReadSign;
use App\Models\Duty;
use App\Models\SpecialFare;
use App\Models\Airline;
use App\Models\AirlineDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\AirlineLibrary;
use App\Models\ApprovedStaff;


use App\Models\FareType;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function libraryupdate(Request $request, $id)
    {
        // Find the document by its ID
        $document = AirlineLibrary::findOrFail($id);

        // Handle the attachment file upload
        // if ($request->hasFile('attachment')) {
        //     $docName = $request->file('attachment');
        //     $fileName = uniqid() . '.' . $docName->getClientOriginalExtension();
        //     $mediaPath = $docName->move(public_path('public/assets/docs/'), $fileName);

        //     if (!$mediaPath) {
        //         return back()->withErrors(['media' => 'Failed to upload document']);
        //     }

        //     // Update the attachment field
        //     $document->attachment = $fileName;
        // }

        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('attachment')) {
            $docFile = $request->file('attachment');

            // foreach ($docFiles as $docFile) {
            // Generate a unique file name with extension
            $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();

            // Define the storage path
            $storagePath = ('public/assets/docs/');

            // Check if the directory exists, if not create it
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            // Move the file to the defined path
            $docFile->move($storagePath, $fileName);

            // Add the filename to the array
            $fileNames[] = asset('public/assets/docs/') . "/" . $fileName;
            // }
        }
        // Convert array to a JSON string or comma-separated string
        $fileNamesString = json_encode($fileNames); // Use this if you prefer JSON format


        // Update other fields
        $document->airline_id = $request->input('airline_id');
        $document->staff_id = $request->input('staff_id');
        $document->doc_name = $request->input('doc_name');
        $document->issue_date = $request->input('issue_date');
        $document->effective_date = now();
        $document->attachment = $fileNamesString;
        $document->edition_no = $request->input('edition_no');


        $document->updated_by = auth()->user()->name; // Assuming you want to store the user ID
        $document->updated_at = now();


        $document->read_sign = 1;


        $document->save();


        return redirect()->back()->with('success', 'Document updated successfully!');
    }

    public function libraryDelete($id, Request $request)
    {
        $library = AirlineLibrary::findOrFail($id);
        $library->update([
            'deleted_at' => now(),
            'remarks' => $request->input('remarks')
        ]);
        return redirect()->back()->with('success', 'Library deleted successfully');
    }
    public function storeLibrary(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
        ]);


        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('documents')) {
            $docFile = $request->file('documents');

            // foreach ($docFiles as $docFile) {
            // Generate a unique file name with extension
            $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();

            // Define the storage path
            $storagePath = ('public/assets/docs/');

            // Check if the directory exists, if not create it
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true, true);
            }

            // Move the file to the defined path
            $docFile->move($storagePath, $fileName);

            // Add the filename to the array
            $fileNames[] = asset('public/assets/docs/') . "/" . $fileName;
            // }
        }
        // Convert array to a JSON string or comma-separated string
        $fileNamesString = json_encode($fileNames); // Use this if you prefer JSON format

        $library = AirlineLibrary::create([
            'airline_id' => $request->input('airline_id'),
            'staff_id' => $request->input('staff_id'),
            'doc_name' => $request->input('doc_name'),
            'edition_no' => $request->input('edition_no'),
            'issue_date' => $request->input('issue_date'),
            'attachment' => $fileNamesString,
            'uploaded_by' => auth()->user()->id,
        ]);


        return redirect()->back();
    }

    public function PemployeeProfile($id)
    {
        $employees = User::find($id);
        return view('admin.view-profile', compact('employees'));
    }

    public function viewUserProfile()
    {
        $employees = User::where('role_id', 2)->get();
        $department = Department::latest()->get();
        $designation = Designation::latest()->get();

        return view('admin.view-employee', compact('employees', 'department', 'designation'));
    }

    public function storeUserProfile(Request $request)
    {

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

    public function viewUserRights()
    {
        $department_rights = DepartmentRight::where('status', 1)->get();
        $department = Department::latest()->get();
        $duties = Duty::latest()->get();

        $specialFare = SpecialFare::where('agent_id', 4)->get();

        $fareType = FareType::get();


        return view('admin.view-rights', compact('department_rights', 'department', 'duties'));
    }

    public function storeUserRights(Request $request)
    {

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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        // Attempt to log the user in
        if (Auth::guard('employee')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $admin = Auth::guard('employee')->user();
            $name = $admin->first_name . " " . $admin->last_name;
            $request->session()->put('employee_name', $name);
            $request->session()->put('email', $admin->email);
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

        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.role_id', 2)
            ->get(['clients.*', 'users.*']);
        $department = Department::latest()->get();
        $designation = Designation::latest()->get();

        $departmentEmployees = User::where('role_id', 2)
            ->get()
            ->groupBy('department');

        return view('admin.employees', compact('employees', 'department', 'designation', 'departmentEmployees'));
    }

    // Display the employee's details and leave information
    public function approvedStaffRightsStore(Request $request)
    {
        foreach ($request->input('airline') as $airlineId => $duties) {
            foreach ($duties as $duty => $status) {

                $specialFare =  ApprovedStaff::updateOrCreate(
                    [
                        'airline_id' => $airlineId,
                        'duties' => $duty,
                        'staff_id' => $request->staff_id
                    ],
                    [
                        'status' => $status
                    ]
                );

                if ($specialFare->wasRecentlyCreated) {
                    $specialFare->created_by = Auth()->user()->name;
                    $specialFare->updated_at = $request->input('updated_at'); // Assuming user authentication is used
                } else {
                    $specialFare->updated_by = auth()->user()->name;
                    $specialFare->updated_at = now();
                }

                // Save the changes
                $specialFare->save();
            }
        }

        return redirect()->back()->with('success', 'Approved Staff data updated successfully.');
    }
    public function viewEmployee($id, Request $request)
    {

        $airlineDetails = AirlineDetail::where('deleted_at', null)->orWhere('deleted_at', 'null')->get();
        $duty = Duty::where('status', 1)->get();
        $Staffs = User::where('status', 'active')->get();
        $approvedStaffs = ApprovedStaff::where('status', 1)->where('airline_id', $id)->get();
        $usedAnnualLeave = EmployeeLeave::where('employee_id', $id)->where('status', 3)->where('leave_type', 'Annual Leave')
            ->sum('no_of_days');
        $library = AirlineLibrary::where('deleted_at', null)->orWhere('deleted_at', 'null')->where('staff_id', $id)->get();
        $airline = AirlineDetail::where('deleted_at', NULL)->with('airline')->get();
        $employee = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.id', $id)
            ->first(['clients.*', 'users.*']);
        $allEmployee = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->get(['clients.*', 'users.*']);
        $employees = User::find($id);

        $currentDate = \Carbon\Carbon::now()->format('l, j.n.Y');

        $total_leave_taken = EmployeeLeave::where('employee_id', $id)
            ->where('status', 1)
            ->get()
            ->sum(function ($leave) {
                return \Carbon\Carbon::parse($leave->from)->diffInDays(\Carbon\Carbon::parse($leave->to)) + 1;
            });

        $tl = EmployeeLeave::where('employee_id', $id)->sum('no_of_days');
        $eel = User::where('id', $id)->first();

        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())->count();

        $approvedLeaves = EmployeeLeave::where('employee_id', $id)->where('leave_type', 'Annual Leave')->where('status', 3)->sum('no_of_days');
        $total_pending_leaves = EmployeeLeave::where('employee_id', $id)->where('status', 2)->sum('no_of_days');
        $total_declined_leaves = EmployeeLeave::where('employee_id', $id)->where('status', 4)->sum('no_of_days');

        $remaining_leaves = $eel->leave_count - $approvedLeaves;
        $leave_used_percentage = ($total_leaves > 0) ? ($total_leave_taken / $total_leaves) * 100 : 0;
        $leave_used_percentage = min(100, max(0, $leave_used_percentage));

        $absent_colleagues = EmployeeLeave::whereDate('from', '<=', \Carbon\Carbon::today()->toDateString())
            ->whereDate('to', '>=', \Carbon\Carbon::today()->toDateString())
            ->get();

        $approvedLeaves = EmployeeLeave::where('status', 3)->count();
        $total_min_hrs = User::where('id', $id)->first();
        $total_max_hrs = User::where('id', $id)->first();
        $total_overtime = (float)$total_max_hrs->max_hrs - (float)$total_min_hrs->max_hrs;


        $total_employee = Client::count();

        $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())
            ->count();
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;

        $holidays = Holiday::select('holiday_date')->get();

        // Calculate approved leaves for the current month

        // Fetch leaves by type for the authenticated user
        $leaveData = EmployeeLeave::where('employee_id', $id)->where('status', 3)
            ->get();
        $userData = User::where('id', $id)->first();
        $annualLeave = $userData->leave_count ?? 0;
        $absencePerMonth = EmployeeLeave::where('employee_id', $id)
            ->where('status', 3) // Approved status
            ->whereMonth('from', now()->month)
            ->whereYear('from', now()->year)
            ->count();

        $remainingLeave = $annualLeave - $usedAnnualLeave;
        $total_holidays = $usedAnnualLeave +  $remainingLeave;

        $leavetypes = LeaveType::where('status', 1)->get();
        $staffReadSign = StaffReadSign::where('staff_id', $id)->get();
        $employee_leaves_view = EmployeeLeave::where('employee_id', $id)->latest()->get();
        $users = User::where('department', '!=', null)->get()->groupBy('department');

        // If this is an AJAX request
        if ($request->ajax()) {
            $type = $request->get('type'); // 'coworker', 'team', or 'browse_list'
            $value = $request->get('value'); // Selected value from the dropdown

            $filteredData = [];

            if ($type === 'coworker') {
                // Filter data based on coworker (employee ID)
                $filteredData = User::where('id', $value)->get();
            } elseif ($type === 'team') {
                // Filter data based on team (department)
                $filteredData = User::where('department', $value)->get();
            } elseif ($type === 'browse_list') {
                // Filter data based on browse list (user ID)
                $filteredData = User::where('id', $value)->get();
            }

            // Prepare filtered employee leave data for calendar display
            $calendarData = [];
            foreach ($filteredData as $employee) {
                // Fetching leave dates for the employee
                $employeeLeaves = DB::table('employee_leaves')
                    ->where('employee_id', $employee->id)
                    ->get();

                // Create an array of leave days
                $leaveDays = [];
                $currentMonth = \Carbon\Carbon::now()->month; // Get the current month

                foreach ($employeeLeaves as $leave) {
                    $fromDate = \Carbon\Carbon::parse($leave->from);
                    $toDate = \Carbon\Carbon::parse($leave->to);

                    // Check if the leave falls within the current month
                    if (
                        $fromDate->month === $currentMonth ||
                        $toDate->month === $currentMonth
                    ) {
                        // Generate all days between from and to date
                        while ($fromDate->lte($toDate)) {
                            $leaveDays[] = $fromDate->day;
                            $fromDate->addDay();
                        }
                    }
                }

                $calendarData[] = [
                    'employee' => $employee,
                    'leaveDays' => $leaveDays,
                ];
            }

            return response()->json(['calendarData' => $calendarData]);
        }

        $departments = Department::get();

        // For the normal view (non-AJAX request)
        if ($departments->isEmpty()) {
            return response()->json(['error' => 'No departments found'], 404);
        }
        return view('admin.view-profile', compact(
            'departments',
            'approvedStaffs',
            'Staffs',
            'duty',
            'airlineDetails',
            'users',
            'allEmployee',
            'holidays',
            'leaveData',
            'total_holidays',
            'remainingLeave',
            'usedAnnualLeave',
            'library',
            'airline',
            'staffReadSign',
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

        return redirect()->route('admin.employees')->with('success', 'Employee added successfully');
    }
    public function edit(Request $request, $id)
    {
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
        return view('admin.manage-staff', compact('employees', 'department', 'designation', 'total_employee', 'total_leaves', 'total_pending_leaves', 'total_leaves', 'employee_leaves', 'noofpresentemployeestoday'));
    }


    public function viewEmployeeProfile(Request $request, $id)
    {
        $employeeProfile = Employee::find($id);
        return view('admin.employee-profile', compact('employeeProfile'));
    }

    // public function holidays()
    // {


    //     $holidays = Holiday::latest()->get();
    //     $total_employee = Client::count();
    //     $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
    //     ->get(['clients.*', 'users.*']);
    //     $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
    //                                              ->whereDate('to', '>=', now()->toDateString())->count();
    //     $total_pending_leaves = EmployeeLeave::where('status', 2)->count();
    //     //$employee_leaves = EmployeeLeave::latest()->get();
    //     $employee_leaves = EmployeeLeave::latest()->get();
    //     // Number of employees on leave today
    //     $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
    //                                              ->whereDate('to', '>=', now()->toDateString())
    //                                              ->count();
    //     // Number of present employees today
    //     $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;

    //     $leavetypes = LeaveType::where('status',1)->get();

    //     $departments = Department::get();
    //     $users = User::where('department', '!=', null)->get()->groupBy('department');



    //     if ($departments->isEmpty()) {
    //         return response()->json(['error' => 'No departments found'], 404);
    //     }
    //     // Add your logic for leaves admin view
    //     return view('admin.holidays', compact('total_employee','employees','total_pending_leaves','total_leaves','employee_leaves','noofpresentemployeestoday', 'holidays', 'leavetypes', 'departments', 'users')); // Example view path, adjust as per your structure


    // }

    public function holidays(Request $request)
    {
        $holidays = Holiday::latest()->get();
        $total_employee = Client::count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->get(['clients.*', 'users.*']);
        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)->count();
        $employee_leaves = EmployeeLeave::latest()->get();
        $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())
            ->count();
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;
        $leavetypes = LeaveType::where('status', 1)->get();
        $departments = Department::get();
        $users = User::where('department', '!=', null)->get()->groupBy('department');

        // If this is an AJAX request
        if ($request->ajax()) {
            $type = $request->get('type'); // 'coworker', 'team', or 'browse_list'
            $value = $request->get('value'); // Selected value from the dropdown

            $filteredData = [];

            if ($type === 'coworker') {
                // Filter data based on coworker (employee ID)
                $filteredData = User::where('id', $value)->get();
            } elseif ($type === 'team') {
                // Filter data based on team (department)
                $filteredData = User::where('department', $value)->get();
            } elseif ($type === 'browse_list') {
                // Filter data based on browse list (user ID)
                $filteredData = User::where('id', $value)->get();
            }

            // Prepare filtered employee leave data for calendar display
            $calendarData = [];
            foreach ($filteredData as $employee) {
                // Fetching leave dates for the employee
                $employeeLeaves = DB::table('employee_leaves')
                    ->where('employee_id', $employee->id)
                    ->get();

                // Create an array of leave days
                $leaveDays = [];
                $currentMonth = \Carbon\Carbon::now()->month; // Get the current month

                foreach ($employeeLeaves as $leave) {
                    $fromDate = \Carbon\Carbon::parse($leave->from);
                    $toDate = \Carbon\Carbon::parse($leave->to);

                    // Check if the leave falls within the current month
                    if (
                        $fromDate->month === $currentMonth ||
                        $toDate->month === $currentMonth
                    ) {
                        // Generate all days between from and to date
                        while ($fromDate->lte($toDate)) {
                            $leaveDays[] = $fromDate->day;
                            $fromDate->addDay();
                        }
                    }
                }

                $calendarData[] = [
                    'employee' => $employee,
                    'leaveDays' => $leaveDays,
                ];
            }

            return response()->json(['calendarData' => $calendarData]);
        }

        // For the normal view (non-AJAX request)
        if ($departments->isEmpty()) {
            return response()->json(['error' => 'No departments found'], 404);
        }

        return view('admin.holidays', compact('total_employee', 'employees', 'total_pending_leaves', 'total_leaves', 'employee_leaves', 'noofpresentemployeestoday', 'holidays', 'leavetypes', 'departments', 'users'));
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
            'category' => $request->input('category') ?? 'bg-purple',
            'state' => $request->input('state'),
            'country' => $request->input('country'),
        ]);


        $holidays = Holiday::latest()->get();
        // Add your logic for holidays view
        return redirect()->route('admin.holidays');
    }
    public function holidayUpdate(Request $request, $id)
    {
        // Create a new employee
        $holiday =  Holiday::find($id);
        $holiday->update([
            'title' => $request->input('title'),
            'holiday_date' => $request->input('holiday_date'),
            'holiday_day' => $request->input('holiday_day'),
            'category' => $request->input('category') ?? 'bg-purple',
            'state' => $request->input('state'),
            'country' => $request->input('country'),
        ]);
        $holidays = Holiday::latest()->get();
        // Add your logic for holidays view
        return redirect()->route('admin.holidays');
    }

    public function leavesAdmin()
    {

        $leavetypes = LeaveType::where('status', 1)->get();
        $total_employee = Client::count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->get(['clients.*', 'users.*']);
        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())->where('leave_type', 'Annual Leave')->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)->where('leave_type', 'Annual Leave')->count();
        //$employee_leaves = EmployeeLeave::latest()->get();
        $employee_leaves = EmployeeLeave::where('status', 1)->get();
        $pending_employee_leaves = EmployeeLeave::where('status', 2)->get();
        $approved_employee_leaves = EmployeeLeave::where('status', 3)->get();
        $rejected_employee_leaves = EmployeeLeave::where('status', 4)->get();
        // Number of employees on leave today
        $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())->where('leave_type', 'Annual Leave')
            ->count();
        // Number of present employees today
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;
        // Add your logic for leaves admin view
        return view('admin.leaves', compact('total_employee', 'employees', 'total_pending_leaves', 'total_leaves', 'employee_leaves', 'leavetypes', 'noofpresentemployeestoday', 'rejected_employee_leaves', 'approved_employee_leaves', 'pending_employee_leaves')); // Example view path, adjust as per your structure
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
        $total_leaves = Employee::where('id', $employee->id)->where('leave_type', 'Annual Leave')->pluck('leave_count')->first();
        $medical_leave = EmployeeLeave::where('employee_id', $employee->id)->where('leave_type', 'Medical Leave')->count();
        $other_leave = EmployeeLeave::where('employee_id', $employee->id)
            ->where('leave_type', '!=', 'Medical Leave')
            ->count();
        $total_taken = EmployeeLeave::where('employee_id', $employee->id)->where('leave_type', 'Annual Leave')->count();
        $remaining_leave = $total_leaves - $total_taken;
        $leaves = EmployeeLeave::where('employee_id', $employee->id)->get();
        return view('admin.leaves-employee', compact('total_leaves', 'medical_leave', 'other_leave', 'remaining_leave', 'leaves')); // Example view path, adjust as per your structure
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

    public function EmployeeReadSignStore(Request $request)
    {
        // Get the file
        // if ($request->hasFile('attachment')) {
        //     $file = $request->file('attachment');

        //     // Generate a unique file name
        //     $fileName = $file. '.' . $file->getClientOriginalExtension();

        //     // Log file details
        //     logger("File details: ", [
        //         'original_name' => $file->getClientOriginalName(),
        //         'mime_type' => $file->getMimeType(),
        //         'size' => $file->getSize(),
        //     ]);

        //     $storagePath = public_path('assets/docs');

        //     // Ensure the directory exists
        //     if (!File::exists($storagePath)) {
        //         File::makeDirectory($storagePath, 0755, true, true);
        //     }

        //     // Move the file
        //     $file->move($storagePath, $fileName);
        // } else {
        //     logger('No file was uploaded.');
        // }
        StaffReadSign::create([
            'airline_id' => $request->input('airline_id'),
            'staff_id' => $request->input('staff_id'),
            'doc_name' => $request->input('doc_name'),
            'attachment' => 'null',
            'created_by' => Auth()->user()->name,
            'updated_at' => $request->input('updated_at'),

        ]);
        return redirect()->back()->with('success', ' Document Uploaded successfully');
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
    public function EmployeeReadSignUpdate($id, Request $request)
    {
        $read =  StaffReadSign::find($id);
        $read->update([
            'sign_doc' => $request->input('sign_document'),
            'updated_by' => Auth()->user()->name
        ]);
        // Add your logic for leaves admin view
        return redirect()->back()->with('success', 'Signed Successfully added successfully');
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

    public function storeReportSick(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'leave_type' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'note' => 'nullable|string',
            'no_of_days' => 'nullable|integer',
            'reason' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $attachment = $request->file('attachment');
            $path = $attachment->store('attachments', 'public');
        } else {
            $path = null; // Handle accordingly
        }

        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'note' => $request->input('note'),
            'no_of_days' => $request->input('no_of_days'),
            'attachment' => $path,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Sick Report added successfully');
    }



    public function storeNewAbsence(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'leave_type' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'absence_series' => 'nullable|string',
            'note' => 'nullable|string',
            'representation' => 'nullable|string',
            'no_of_days' => 'nullable|integer',
            'reason' => 'nullable|string',
        ]);

        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'absence_series' => $request->input('absence_series'),
            'note' => $request->input('note'),
            'representation' => $request->input('representation'),
            'status' => 1
        ]);
        // Add your logic for leaves admin view
        return redirect()->back()->with('success', 'New Absence added successfully');
    }

    public function getHolidays()
    {
        $holidays = Holiday::select('holiday_date')->get();
        return response()->json($holidays);
    }

    public function getDepartments()
    {
        $departments = User::whereNotNull('department')
            ->select('department')
            ->distinct()
            ->pluck('department');

        return response()->json(['departments' => $departments]);
    }
    public function getEmployeesByUsers($user_id)
    {
        $users = User::where('id', $user_id)->get();

        foreach ($users as $user) {
            $employeeLeaves = DB::table('employee_leaves')
                ->where('employee_id', $user->id)
                ->get();

            $leaveDays = [];
            $currentMonth = Carbon::now()->month;

            foreach ($employeeLeaves as $leave) {
                $fromDate = Carbon::parse($leave->from);
                $toDate = Carbon::parse($leave->to);

                if ($fromDate->month === $currentMonth && $toDate->month === $currentMonth) {
                    while ($fromDate->lte($toDate)) {
                        $leaveDays[] = $fromDate->day;
                        $fromDate->addDay();
                    }
                }
            }

            $user->leaveDays = $leaveDays;
        }

        return response()->json(['users' => $users]);
    }

    public function getEmployeesByDepartment($department)
    {
        $users = User::where('department', $department)->get();

        foreach ($users as $user) {
            $employeeLeaves = DB::table('employee_leaves')
                ->where('employee_id', $user->id)
                ->get();

            $leaveDays = [];
            $currentMonth = Carbon::now()->month;

            foreach ($employeeLeaves as $leave) {
                $fromDate = Carbon::parse($leave->from);
                $toDate = Carbon::parse($leave->to);

                if ($fromDate->month === $currentMonth && $toDate->month === $currentMonth) {
                    while ($fromDate->lte($toDate)) {
                        $leaveDays[] = $fromDate->day;
                        $fromDate->addDay();
                    }
                }
            }

            $user->leaveDays = $leaveDays;
        }

        return response()->json(['users' => $users]);
    }
}
