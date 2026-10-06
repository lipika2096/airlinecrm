<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Admin;
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
use Illuminate\Support\Facades\Auth;


use App\Models\FareType;
use App\Rules\UniqueEmailAcrossTables;
use App\Rules\UniqueEmailAcrossTablesExcept;
use App\Models\ModulePermission;
use Spatie\Permission\Models\Permission;

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

        if($request->hasFile('attachment')){
            $document->attachment = $fileNamesString;
        }
        // Update other fields
        $document->airline_id = $request->input('airline_id');
        $document->staff_id = $request->input('staff_id');
        $document->doc_name = $request->input('doc_name');
        $document->issue_date = $request->input('issue_date');
        $document->effective_date = now();
        $document->edition_no = $request->input('edition_no');


        $document->updated_by = auth('admin')->user()->name; // Assuming you want to store the user ID
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
            'uploaded_by' => auth('admin')->user()->id,
        ]);


        return redirect()->back();
    }

    public function PemployeeProfile($id)
    {
        $employees = User::where('id', $id)->whereNull('deleted_at')->first();

        // Debug: Check if employee exists
        if (!$employees) {
            \Log::error('Employee not found with ID: ' . $id);
            abort(404, 'Employee not found');
        }

        // Load module permissions for this employee - handle both string and integer employee_id
        $modulePermissions = ModulePermission::where(function($query) use ($id) {
            $query->where('employee_id', $id)
                  ->orWhere('employee_id', (string)$id);
        })
        ->get()
        ->map(function ($permission) {
            return [
                'module_name' => $permission->module_name,
                'has_access' => (bool) $permission->has_access,
                'can_view' => (bool) $permission->can_view,
                'can_create' => (bool) $permission->can_create,
                'can_edit' => (bool) $permission->can_edit,
                'can_delete' => (bool) $permission->can_delete,
                'permissions' => $permission->permissions
            ];
        })
        ->keyBy('module_name')
        ->toArray();


        // Get available modules from permissions table
        $allPermissions = Permission::where('guard_name', 'web')->get();
        $availableModules = [];

        // Get employee's departments
        $employeeDepartments = $employees->department_names;

        // Get modules assigned to employee's departments
        $departmentModules = [];
        if (!empty($employeeDepartments)) {
            $departmentModules = \App\Models\DepartmentModule::whereIn('department_name', $employeeDepartments)
                ->where('is_active', true)
                ->pluck('module_name')
                ->toArray();
        }

        foreach ($allPermissions as $permission) {
            // Extract main module name (before the first dot)
            $moduleName = explode('.', $permission->name)[0];

            // Only add if it's not already in the array and it's a main module
            // AND it's assigned to the employee's department (or if no departments assigned, show all)
            if (!array_key_exists($moduleName, $availableModules) && !str_contains($permission->name, '.')) {
                // If employee has departments, only show modules assigned to those departments
                if (!empty($departmentModules)) {
                    if (in_array($moduleName, $departmentModules)) {
                        $availableModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
                    }
                } else {
                    // If no departments assigned, show all modules (fallback behavior)
                    $availableModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
                }
            }
        }

        // Sort modules alphabetically
        asort($availableModules);

        return view('admin.view-profile', compact('employees', 'modulePermissions', 'availableModules', 'allPermissions'));
    }

    public function viewUserProfile()
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin') ) {
            $currentUserId = auth('admin')->user()->id;
            $userType = 'superadmin';
        } elseif (auth()->check()) {    
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        elseif(auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')){
            $currentUserId = auth('admin')->user()->id;
            $userType = 'customer';
        }
        
        // Build query based on user type
        $query = User::with('userDepartments')->where('role_id', 2)->whereNull('deleted_at');
        
        // For non-superadmin users, only show employees they created
        if ($userType !== 'superadmin') {
            $query->where('created_by', $currentUserId);
        }
        
        $employees = $query->get();
        
        // Load department names for each employee from both sources
        foreach ($employees as $employee) {
            $deptNames = $employee->department_names;
            // Ensure it's always an array
            if (!is_array($deptNames)) {
                $deptNames = !empty($deptNames) ? [$deptNames] : [];
            }
            $employee->department_names = $deptNames;
        }

        // Scope departments and designations based on user role
        if ($userType === 'customer' || $userType === 'staff') {
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
        } else {
            // Super admin sees all departments and designations
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
        }

        return view('admin.view-employee', compact('employees', 'department', 'designation'));
    }

    public function storeUserProfile(Request $request)
    {
        dd($request);
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', new UniqueEmailAcrossTables],
            'phone' => 'nullable|string|max:20',
            'joining_date' => 'nullable|date',
            'leave_count' => 'nullable|integer',
            'department' => 'nullable|string',
            'designation' => 'nullable|string',
            'min_hrs' => 'nullable|string',
            'max_hrs' => 'nullable|string',
            'work_type' => 'nullable|string',
            'branch' => 'nullable|string',
            'company_mobile' => 'nullable|string',
        ]);

    // Auto-generate unique password based on user details
        $symbols = ['@', '#', '$', '%', '&', '*', '!', '?'];
        $randomSymbol = $symbols[array_rand($symbols)];

        $defaultPassword = strtoupper(substr($request->input('first_name'), 0, 3)) . 
                           $randomSymbol . 
                           substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3) . 
                           rand(100, 999);

        // Auto-generate random employee ID
        $year = date('Y');
        $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $employeeId = 'EMP-' . $year . '-' . $randomNumber;

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
        $user->password = bcrypt($defaultPassword);
        $user->unique_id = $employeeId;
        $user->phone = $request->phone;
        $user->joining_date = $request->joining_date;
        $user->leave_count = $request->leave_count;
        $user->department = $request->department ?? null;
        $user->position = $request->designation ?? null;
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
        $user->created_by = auth('admin')->user()->id;
        $user->save();
        // Send password to user email with reset link
        try {
            $resetLink = url('/forgot-password');
            \Mail::raw("Hello {$request->input('first_name')} {$request->input('last_name')},\n\nYour staff account has been created successfully.\n\nYour login credentials:\nEmail: {$request->input('email')}\nTemporary Password: {$defaultPassword}\n\nFor security, we recommend changing your password after first login.\n\nIf you need to reset your password, visit: {$resetLink}\n\nThank you.", function($message) use ($request) {
                $message->to($request->input('email'))
                        ->subject('Your Staff Account Credentials');
            });
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to send email: ' . $e->getMessage());
        }

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
        $employee =  User::where('id', $id)->whereNull('deleted_at')->first();
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
            'dob' => $request->input('dob'),
            'updated_by' => auth('admin')->user()->id
        ]);
        return redirect()->back()->with('success', 'Employee added successfully');
    }

    public function viewUserRights()
    {
        $department_rights = DepartmentRight::where('status', 1)->where('created_by', auth('admin')->user()->id)->get();
        $department = Department::latest()->where('created_by', auth('admin')->user()->id)->get();
        $duties = Duty::latest()->where('created_by', auth('admin')->user()->id)->get();

        $specialFare = SpecialFare::where('agent_id', 4)->get();

        $fareType = FareType::where('created_by', auth('admin')->user()->id)->get();


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
                        'status' => $status,
                        'created_by' => auth('admin')->user()->id
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
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        $createdBySuperadmin = false;
        $superadminId = null;
        
        if (auth('admin')->check() ) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
            
            // Check if this staff was created by a superadmin
            $currentUser = User::where('id', $currentUserId)->whereNull('deleted_at')->first();
            if ($currentUser && $currentUser->created_by) {
                $creator = Admin::find($currentUser->created_by);
                if ($creator && $creator->hasRole('SuperAdmin')) {
                    $createdBySuperadmin = true;
                    $superadminId = $creator->id;
                }
            }
        }
        
        // Build query based on user type
        $query = User::with(['client', 'userDepartments'])->where('role_id', 2)->whereNull('deleted_at');
        
        // Apply filtering based on user type
        if ($userType === 'superadmin') {
            // Superadmin sees all staff members
            $query->where('created_by', $currentUserId);
        } elseif ($userType === 'customer') {
            // Customer sees only staff members they created
            $query->where('created_by', $currentUserId);
        } elseif ($userType === 'staff') {
            // Staff: if created by superadmin, show all staff created by that superadmin
            // Otherwise, show only staff they created
            $currentUserDetail = User::where('id', auth()->user()->id)->whereNull('deleted_at')->first();
            //dd($superadminId);
            if ($currentUserDetail->created_by == $superadminId) {
                $query->where(function($q) use ($superadminId, $currentUserId) {
                    $q->where('created_by', $superadminId)
                      ->orWhere('created_by', $currentUserId);
                })->whereNull('deleted_at');
            } else {
                $query->where('created_by', $currentUserId)->whereNull('deleted_at');
            }
        }
        
        $employees = $query->get();

        // Load department names for each employee from both sources
        foreach ($employees as $employee) {
            $deptNames = $employee->department_names;
            // Ensure it's always an array
            if (!is_array($deptNames)) {
                $deptNames = !empty($deptNames) ? [$deptNames] : [];
            }
            $employee->department_names = $deptNames;
        }

        // Scope departments and designations based on user role
        if ($userType === 'customer' || $userType === 'staff') {
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
        } else {
            // Super admin sees all departments and designations
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
        }

        // Build department employees query with same scoping
        $deptQuery = User::with('userDepartments')->where('role_id', 2)->whereNull('deleted_at');
        
        // Apply same filtering logic as main query
        if ($userType === 'superadmin') {
            // Superadmin sees all staff members
            $deptQuery->where('created_by', $currentUserId);
        } elseif ($userType === 'customer') {
            // Customer sees only staff members they created
            $deptQuery->where('created_by', $currentUserId);
        } elseif ($userType === 'staff') {
            // Staff: if created by superadmin, show all staff created by that superadmin
            // Otherwise, show only staff they created
            $currentUserDetail = User::where('id', auth()->user()->id)->whereNull('deleted_at')->first();
            if ($currentUserDetail->created_by == $superadminId) {
                $deptQuery->where(function($query) use ($superadminId, $currentUserId) {
                    $query->where('created_by', $superadminId)
                          ->orWhere('created_by', $currentUserId);
                })->whereNull('deleted_at');
            } else {
                $deptQuery->where('created_by', $currentUserId)->whereNull('deleted_at');
            }
        }
        
        // Get all employees with their departments
        $allEmployees = $deptQuery->get();
        
        // Build a collection where each employee appears under each of their departments
        $departmentEmployees = collect();
        
        foreach ($allEmployees as $employee) {
            $deptNames = $employee->department_names;
            // Ensure it's always an array
            if (!is_array($deptNames)) {
                $deptNames = !empty($deptNames) ? [$deptNames] : [];
            }
            $employee->department_names = $deptNames;
            
            // If employee has departments, add them to each department group
            if (!empty($deptNames) && is_array($deptNames)) {
                foreach ($deptNames as $deptName) {
                    $departmentEmployees->push([
                        'department' => $deptName,
                        'employee' => $employee
                    ]);
                }
            } else {
                // If no departments, add to 'No Department' group
                $departmentEmployees->push([
                    'department' => $employee->department ?? 'No Department',
                    'employee' => $employee
                ]);
            }
        }
        
        // Group by department
        $departmentEmployees = $departmentEmployees->groupBy('department')
            ->map(function($group) {
                return $group->pluck('employee');
            });

        return view('admin.employees', compact('employees', 'department', 'designation', 'departmentEmployees'));
    }

    public function addStaff()
    {
        // Determine the current user type and ID for data scoping
        $currentUserId = null;
        $userType = 'superadmin'; // default
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Generate next employee ID for preview
        $year = date('Y');
        $lastEmployee = User::where('unique_id', 'like', 'EMP-' . $year . '%')
                           ->whereNull('deleted_at')
                           ->orderBy('id', 'desc')
                           ->first();
        
        if ($lastEmployee) {
            // Extract the last number and increment
            $lastNumber = (int) substr($lastEmployee->unique_id, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        $nextEmployeeId = 'EMP-' . $year . '-' . $newNumber;
        
        // Scope departments and designations based on user role
        
            // Super admin sees all departments and designations
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
        
        
        return view('admin.add-staff', compact('department', 'designation', 'nextEmployeeId'));
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
                    $specialFare->created_by = auth('admin')->user()->name;
                    $specialFare->updated_at = $request->input('updated_at'); // Assuming user authentication is used
                } else {
                    $specialFare->updated_by = auth('admin')->user()->name;
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
        $Staffs = User::where('status', 'active')->whereNull('deleted_at')->get();
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
        $employees = User::where('id', $id)->whereNull('deleted_at')->first();

        $currentDate = \Carbon\Carbon::now()->format('l, j.n.Y');

        $total_leave_taken = EmployeeLeave::where('employee_id', $id)
            ->where('status', 1)
            ->get()
            ->sum(function ($leave) {
                return \Carbon\Carbon::parse($leave->from)->diffInDays(\Carbon\Carbon::parse($leave->to)) + 1;
            });

        $tl = EmployeeLeave::where('employee_id', $id)->sum('no_of_days');
        $eel = User::where('id', $id)->whereNull('deleted_at')->first();

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
        $total_min_hrs = User::where('id', $id)->whereNull('deleted_at')->first();
        $total_max_hrs = User::where('id', $id)->whereNull('deleted_at')->first();
        $total_overtime = (float)$total_max_hrs->max_hrs - (float)$total_min_hrs->max_hrs;


        $total_employee = Client::count();

        $employees_on_leave_today = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())
            ->count();
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;

        $holidays = Holiday::select('holiday_date')->get();

        // Calculate approved leaves for the current month

        // Fetch leaves by type for the authenticated user
        $leaveData = EmployeeLeave::where('employee_leaves.employee_id', $id)
        ->join('leave_types', 'employee_leaves.leave_type', '=', 'leave_types.name')
        ->where('employee_leaves.status', 3)
        ->select('employee_leaves.*', 'leave_types.color')
        ->get();;
        $userData = User::where('id', $id)->whereNull('deleted_at')->first();
        $annualLeave = $userData->leave_count ?? 0;
        $absencePerMonth = EmployeeLeave::where('employee_id', $id)
            ->where('status', 3) // Approved status
            ->whereMonth('from', now()->month)
            ->whereYear('from', now()->year)
            ->count();

        $remainingLeave = $annualLeave - $usedAnnualLeave;
        $total_holidays = $usedAnnualLeave +  $remainingLeave;
        $userGetId = auth('admin')->user()->id ?? auth()->user()->id;

        $leavetypes = LeaveType::where('status', 1)->get();
        $staffReadSign = StaffReadSign::where('staff_id', $id)->get();
        $employee_leaves_view = EmployeeLeave::where('employee_id', $id)->latest()->get();
        $users = User::where('department', '!=', null)->where('created_by', $userGetId)->whereNull('deleted_at')->get()->groupBy('department');

        // If this is an AJAX request
        if ($request->ajax()) {
            $type = $request->get('type'); // 'coworker', 'team', or 'browse_list'
            $value = $request->get('value'); // Selected value from the dropdown

            $filteredData = [];

            if ($type === 'coworker') {
                // Filter data based on coworker (employee ID)
                $filteredData = User::where('id', $value)->whereNull('deleted_at')->get();
            } elseif ($type === 'team') {
                // Filter data based on team (department)
                $filteredData = User::where('department', $value)->whereNull('deleted_at')->get();
            } elseif ($type === 'browse_list') {
                // Filter data based on browse list (user ID)
                $filteredData = User::where('id', $value)->whereNull('deleted_at')->get();
            }

            // Prepare filtered employee leave data for calendar display
            $calendarData = [];
            foreach ($filteredData as $employee) {
                // Fetching leave dates for the employee
                // $employeeLeaves = DB::table('employee_leaves')
                //     ->where('employee_id', $employee->id)
                //     ->get();
                $employeeLeaves = DB::table('employee_leaves')
                ->join('leave_types', 'employee_leaves.leave_type', '=', 'leave_types.name')
                ->where('employee_leaves.employee_id', $employee->id)
                ->where('employee_leaves.status', 3)
                ->select('employee_leaves.*', 'leave_types.color')
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

        
        // Load module permissions for this employee - handle both string and integer employee_id
        $modulePermissions = ModulePermission::where(function($query) use ($id) {
            $query->where('employee_id', $id)
                  ->orWhere('employee_id', (string)$id);
        })
        ->get()
        ->map(function ($permission) {
            return [
                'module_name' => $permission->module_name,
                'has_access' => (bool) $permission->has_access,
                'can_view' => (bool) $permission->can_view,
                'can_create' => (bool) $permission->can_create,
                'can_edit' => (bool) $permission->can_edit,
                'can_delete' => (bool) $permission->can_delete,
                'permissions' => $permission->permissions
            ];
        })
        ->keyBy('module_name')
        ->toArray();
        //dd($modulePermissions);

        // Get available modules from permissions table
        $allPermissions = Permission::where('guard_name', 'web')->get();
        $availableModules = [];

        // Get employee's departments
        $employeeDepartments = $employees->department_names;

        // Get modules assigned to employee's departments
        $departmentModules = [];
        if (!empty($employeeDepartments)) {
            $departmentModules = \App\Models\DepartmentModule::whereIn('department_name', $employeeDepartments)
                ->where('is_active', true)
                ->pluck('module_name')
                ->toArray();
        }

        foreach ($allPermissions as $permission) {
            // Extract main module name (before the first dot)
            $moduleName = explode('.', $permission->name)[0];

            // Only add if it's not already in the array and it's a main module
            // AND it's assigned to the employee's department (or if no departments assigned, show all)
            if (!array_key_exists($moduleName, $availableModules) && !str_contains($permission->name, '.')) {
                // If employee has departments, only show modules assigned to those departments
                if (!empty($departmentModules)) {
                    if (in_array($moduleName, $departmentModules)) {
                        $availableModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
                    }
                } else {
                    // If no departments assigned, show all modules (fallback behavior)
                    $availableModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
                }
            }
        }

        // Sort modules alphabetically
        asort($availableModules);

        // Pass all permissions to view for submodule configuration
        $allPermissionsArray = $allPermissions->toArray();
        
        return view('admin.view-profile', compact(
            'availableModules',
            'modulePermissions',
            'allPermissions',
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

        $employeeId = $request->input('employee_id');
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }

        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'reason' => $request->input('reason')??'N/A',
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
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
        try{
            
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', new UniqueEmailAcrossTables],
            'phone' => 'nullable|string|max:20',
            'joining_date' => 'nullable|date',
            'leave_count' => 'nullable|integer',
            'department' => 'nullable|string',
            'designation' => 'nullable|string',
            'min_hrs' => 'nullable|string',
            'max_hrs' => 'nullable|string',
            'work_type' => 'nullable|string',
            'branch' => 'nullable|string',
            'company_mobile' => 'nullable|string',
            'date_of_resignation' => 'nullable|string',
            'departments' => 'nullable|array',
            'departments.*' => 'nullable|string',
        ]);

        // Auto-generate unique password based on user details
        $symbols = ['@', '#', '$', '%', '&', '*', '!', '?'];
        $randomSymbol = $symbols[array_rand($symbols)];
        
        $defaultPassword = strtoupper(substr($request->input('first_name'), 0, 3)) . 
                           $randomSymbol . 
                           substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3) . 
                           rand(100, 999);

        // Auto-generate random employee ID
        $year = date('Y');
        $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $employeeId = 'EMP-' . $year . '-' . $randomNumber;
        //dd($request);
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
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($defaultPassword);
        $user->plain_password = $defaultPassword;
        $user->unique_id = $employeeId;
        $user->phone = $request->phone;
        $user->joining_date = $request->joining_date;
        $user->leave_count = $request->leave_count;
        
        // Handle departments - if array, use first as primary, otherwise use single value
        $departments = $request->departments ?? $request->department;
        if (is_array($departments) && !empty($departments)) {
            $user->department = $departments[0]; // Set first department as primary
        } else {
            $user->department = $departments ?? null;
        }
        
        $user->position = $request->designation ?? null;
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
        $user->date_of_resignation = $request->date_of_resignation;
        $user->created_by = auth('admin')->user()->id ?? auth()->user()->id;
        $user->is_active = true;

        $user->save();

        // Handle multiple departments if provided
        if (is_array($departments) && !empty($departments)) {
            $user->syncDepartments($departments);
        }

        // Send password to user email with reset link
        try {
            $resetLink = url('/forgot-password');
            $fullName = $request->first_name . ' ' . $request->last_name;
            \Mail::raw("Hello {$fullName},\n\nYour employee account has been created successfully.\n\nYour login credentials:\nEmail: {$request->input('email')}\nTemporary Password: {$defaultPassword}\n\nFor security, we recommend changing your password after first login.\n\nIf you need to reset your password, visit: {$resetLink}\n\nThank you.", function($message) use ($request) {
                $message->to($request->input('email'))
                        ->subject('Your Employee Account Credentials');
            });
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to send email: ' . $e->getMessage());
        }

        if (\App\Helpers\RouteHelper::isSuperAdmin()) {
            // Determine appropriate redirect route based on user type
            $redirectRoute = 'admin.employees';
            return redirect()->route('admin.employees')->with('success', 'Employee added successfully. Password sent to email.');
        }
        elseif (\App\Helpers\RouteHelper::isCustomer()) {
            $redirectRoute = 'customer.employees';
            return redirect()->route('customer.employees')->with('success', 'Employee added successfully. Password sent to email.');

        } elseif (\App\Helpers\RouteHelper::isStaff()) {
            $redirectRoute = 'staff.employees';
            return redirect()->route('staff.employees')->with('success', 'Employee added successfully. Password sent to email.');

        }
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to create account: ' . $e->getMessage());
            if (\App\Helpers\RouteHelper::isSuperAdmin()) {
                // Determine appropriate redirect route based on user type
                $redirectRoute = 'admin.employees';
                return redirect()->route('admin.employees')->with('error', 'Failed to create account: ' . $e->getMessage());
            }
            elseif (\App\Helpers\RouteHelper::isCustomer()) {
                $redirectRoute = 'customer.employees';
                return redirect()->route('customer.employees')->with('error', 'Failed to create account: ' . $e->getMessage());

            } else {
                $redirectRoute = 'staff.employees';
                return redirect()->route('staff.employees')->with('error', 'Failed to create account: ' . $e->getMessage());

            }

        }
        
    }
    public function edit(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', new UniqueEmailAcrossTablesExcept($id, 'users')],
            'departments' => 'nullable|array',
            'departments.*' => 'nullable|string',
        ]);

        // Find the employee
        $employee = User::where('id', $id)->whereNull('deleted_at')->first();
        
        if (!$employee) {
            // Determine appropriate redirect route based on user type
            $redirectRoute = 'admin.employees';
            if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                $redirectRoute = 'customer.employees';
            } elseif (auth()->check()) {
                $redirectRoute = 'staff.employees';
            }
            return redirect()->route($redirectRoute)->with('error', 'Employee not found');
        }

        // Check if user has permission to edit this employee
        $currentUserId = null;
        $userType = 'superadmin';
        
        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }
        
        // Non-superadmin users can only edit employees they created
        if ($userType !== 'superadmin' && $employee->created_by != $currentUserId) {
            return redirect()->back()->with('error', 'You do not have permission to edit this employee');
        }

        // Get primary department (first selected department)
        $departments = $request->input('departments');

        // Handle backwards compatibility: if no departments array provided, try single department field
        if (empty($departments) || !is_array($departments)) {
            $departments = $request->input('department') ? [$request->input('department')] : [];
        }

        $primaryDepartment = is_array($departments) && !empty($departments) ? $departments[0] : null;

        // Auto-generate random employee ID if null or empty
        $employeeId = $request->input('employee_id');
        if (empty($employeeId)) {
            $year = date('Y');
            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $employeeId = 'EMP-' . $year . '-' . $randomNumber;
        }
        
        // Determine appropriate auth guard for updated_by field
        $updatedBy = null;
        if (auth('admin')->check()) {
            $updatedBy = auth('admin')->user()->id;
        } elseif (auth()->check()) {
            $updatedBy = auth()->user()->id;
        }
        
        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'unique_id' => $employeeId,
            'joining_date' => $request->input('joining_date'),
            'phone' => $request->input('phone'),
            'department' => $primaryDepartment, // Set primary department
            'position' => $request->input('designation'),
            'min_hrs' => $request->input('min_hrs'),
            'max_hrs' => $request->input('max_hrs'),
            'personal_phone' => $request->input('personal_phone'),
            'company_mobile' => $request->input('company_mobile'),
            'branch' => $request->input('branch'),
            'work_type' => $request->input('work_type'),
            'dob' => $request->input('dob'),
            'date_of_resignation' => $request->input('date_of_resignation'),
            'updated_by' => $updatedBy
        ]);

        // Handle multiple departments
        if (is_array($departments) && !empty($departments)) {
            $employee->syncDepartments($departments);
        }

        // Determine appropriate redirect route based on user type
        $redirectRoute = 'admin.employees';
        if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
            $redirectRoute = 'customer.employees';
        } elseif (auth()->check()) {
            $redirectRoute = 'staff.employees';
        }
        
        return redirect()->route($redirectRoute)->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        try {
            // Find the user based on the provided ID
            $user = User::where('id', $id)->whereNull('deleted_at')->firstOrFail();

            // Check if user has permission to delete this employee
            $currentUserId = null;
            $userType = 'superadmin';
            $createdBySuperadmin = false;
            $superadminId = null;
            
            if (auth('admin')->check()) {
                $currentUserId = auth('admin')->user()->id;
                $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
            } elseif (auth()->check()) {
                $currentUserId = auth()->user()->id;
                $userType = 'staff';
                
                // Check if this staff was created by a superadmin
                $currentUser = User::where('id', $currentUserId)->whereNull('deleted_at')->first();
                if ($currentUser && $currentUser->created_by) {
                    $creator = User::where('id', $currentUser->created_by)->whereNull('deleted_at')->first();
                    if ($creator && $creator->hasRole('SuperAdmin')) {
                        $createdBySuperadmin = true;
                        $superadminId = $creator->id;
                    }
                }
            }
            
            // Apply permission logic matching allEmployees function
            if ($userType === 'superadmin') {
                // Superadmin can delete any employee
                // No additional restrictions
            } elseif ($userType === 'customer') {
                // Customer can only delete employees they created
                if ($user->created_by != $currentUserId) {
                    return redirect()->back()->with('error', 'You do not have permission to delete this employee');
                }
            } elseif ($userType === 'staff') {
                // Staff: if created by superadmin, can delete employees created by that superadmin
                // Otherwise, can only delete employees they created
                if ($createdBySuperadmin && $superadminId) {
                    if ($user->created_by != $superadminId) {
                        return redirect()->back()->with('error', 'You do not have permission to delete this employee');
                    }
                } else {
                    if ($user->created_by != $currentUserId) {
                        return redirect()->back()->with('error', 'You do not have permission to delete this employee');
                    }
                }
            }

            // Find the client associated with this user
            $client = Client::where('client_id', $user->clientid)->first();

            // Delete the user and client records
            if ($user) {
                $user->update([
                    'deleted_at' => now()
                ]);
                //$user->delete();
            }

            if ($client) {
                $client->update([
                    'deleted_at' => now()
                ]);
                //$client->delete();
            }

            // Determine appropriate redirect route based on user type
            $redirectRoute = 'admin.employees';
            if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                $redirectRoute = 'customer.employees';
            } elseif (auth()->check()) {
                $redirectRoute = 'staff.employees';
            }
            
            return redirect()->route($redirectRoute)
                ->with('success', 'Employee and associated client deleted successfully.');
        } catch (\Exception $e) {
            // Determine appropriate redirect route based on user type
            $redirectRoute = 'admin.employees';
            if (auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin')) {
                $redirectRoute = 'customer.employees';
            } elseif (auth()->check()) {
                $redirectRoute = 'staff.employees';
            }
            
            return redirect()->route($redirectRoute)
                ->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function manageStaff()
    {
        // Determine current user ID and type
        $currentUserId = null;
        $userType = 'superadmin'; // default

        if (auth('admin')->check()) {
            $currentUserId = auth('admin')->user()->id;
            $userType = auth('admin')->user()->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        } elseif (auth()->check()) {
            $currentUserId = auth()->user()->id;
            $userType = 'staff';
        }

        // Reuse the existing logic to fetch employees
        $employeesQuery = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.role_id', 2);

        // Filter by created_by based on user type
        if ($userType !== 'superadmin') {
            $employeesQuery->where('users.created_by', $currentUserId);
        }

        $employees = $employeesQuery->get(['clients.*', 'users.*']);

        $department = Department::latest()->get();
        $designation = Designation::latest()->get();

        // Count total employees with same filtering logic
        $totalEmployeeQuery = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.role_id', 2);

        if ($userType !== 'superadmin') {
            $totalEmployeeQuery->where('users.created_by', $currentUserId);
        }

        $total_employee = $totalEmployeeQuery->count();

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
        $total_employee = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->where('users.role_id', 2)->where('users.created_by', auth('admin')->user()->id)->count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->where('users.role_id', 2)->where('users.created_by', auth('admin')->user()->id)
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
        $users = User::where('department', '!=', null)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get()->groupBy('department');

        // If this is an AJAX request
        if ($request->ajax()) {
            $type = $request->get('type'); // 'coworker', 'team', or 'browse_list'
            $value = $request->get('value'); // Selected value from the dropdown

            $filteredData = [];

            if ($type === 'coworker') {
                // Filter data based on coworker (employee ID)
                $filteredData = User::where('id', $value)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get();
            } elseif ($type === 'team') {
                // Filter data based on team (department)
                $filteredData = User::where('department', $value)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get();
            } elseif ($type === 'browse_list') {
                // Filter data based on browse list (user ID)
                $filteredData = User::where('id', $value)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get();
            }

            // Prepare filtered employee leave data for calendar display
            $calendarData = [];
            foreach ($filteredData as $employee) {
                // Fetching leave dates for the employee
                // $employeeLeaves = DB::table('employee_leaves')
                //     ->where('employee_id', $employee->id)
                //     ->get();
                $employeeLeaves = DB::table('employee_leaves')
                ->join('leave_types', 'employee_leaves.leave_type', '=', 'leave_types.name')
                ->where('employee_leaves.employee_id', $employee->id)
                ->where('employee_leaves.status', 3)
                ->select('employee_leaves.*', 'leave_types.color')
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
        $total_employee = User::where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->count();
        $employees = Client::join('users', 'users.clientid', '=', 'clients.client_id')->where('users.created_by', auth('admin')->user()->id)
            ->get(['clients.*', 'users.*']);
        $total_leaves = EmployeeLeave::whereDate('from', '<=', now()->toDateString())
            ->whereDate('to', '>=', now()->toDateString())->where('leave_type', 'Annual Leave')->count();
        $total_pending_leaves = EmployeeLeave::where('status', 2)->where('leave_type', 'Annual Leave')->count();
        $employee_leaves = EmployeeLeave::where('status', 1)
        ->orderBy('from', 'desc')
        ->orderBy('to', 'desc')->get();
        $pending_employee_leaves = EmployeeLeave::where('status', 2)
        ->orderBy('from', 'desc')
        ->orderBy('to', 'desc')->get();
        $approved_employee_leaves = EmployeeLeave::where('status', 3)
        ->orderBy('from', 'desc')
        ->orderBy('to', 'desc')->get();
        $rejected_employee_leaves = EmployeeLeave::where('status', 4)
        ->orderBy('from', 'desc')
        ->orderBy('to', 'desc')->get();
        $employees_on_leave_today = EmployeeLeave::select('employee_id')
        ->whereDate('from', '<=', now()->toDateString())
        ->whereDate('to', '>=', now()->toDateString())
        ->where('leave_type', 'Annual Leave')
        ->groupBy('employee_id')
        ->get()
        ->count();
        $noofpresentemployeestoday = $total_employee - $employees_on_leave_today;
        return view('admin.leaves', compact('total_employee', 'employees', 'total_pending_leaves', 'total_leaves', 'employee_leaves', 'leavetypes', 'noofpresentemployeestoday', 'rejected_employee_leaves', 'approved_employee_leaves', 'pending_employee_leaves'));
    }

    public function leavesAdminStore(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }
        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'reason' => $request->input('reason')??'N/A',
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
        ]);
        // Add your logic for leaves admin view
        return redirect()->route('admin.leaves')->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leavesAdminUpdate(Request $request, $id)
    {
        $leaves =  EmployeeLeave::find($id);
        $leaves->update([
            'status' => $request->input('status'),
            'updated_by' =>  auth('admin')->user()->id,
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
        $employeeId = $employee->id;
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }
        EmployeeLeave::create([
            'employee_id' => $employee->id,
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'reason' => $request->input('reason')??'N/A',
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
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
            'created_by' => auth('admin')->user()->name,
            'updated_at' => $request->input('updated_at'),

        ]);
        return redirect()->back()->with('success', ' Document Uploaded successfully');
    }

    public function leavesEmployeeViewStore(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }
        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'reason' => $request->input('reason')??'N/A',
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
        ]);

        // Add your logic for leaves admin view
        return redirect()->back()->with('success', 'Employee added successfully'); // Example view path, adjust as per your structure
    }

    public function leavesEmployeeViewUpdate(Request $request, $id)
    {
        $leaves =  EmployeeLeave::find($id);
        $leaves->update([
            'status' => $request->input('status'),
            'updated_by' =>  auth('admin')->user()->id,
        ]);
        // Add your logic for leaves admin view
        return redirect()->back()->with('success', 'Employee added successfully');
    }
    public function EmployeeReadSignUpdate($id, Request $request)
    {
        $read =  StaffReadSign::find($id);
        $read->update([
            'sign_doc' => $request->input('sign_document'),
            'updated_by' => auth('admin')->user()->name
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
        // Create a new department
        $department = new Department();
        $department->department_name = $request->department_name;
        $department->created_by = auth('admin')->user()->id;

        // Set staff_id based on user role and form input
        if (auth('admin')->user()->role_id == 2) {
            // Staff can only create departments for themselves
            $department->staff_id = auth('admin')->user()->id;
        } else {
            // Super admin can assign to specific staff or leave null for system departments
            $department->staff_id = $request->staff_id ?? null;
        }

        $department->save();

        return redirect()->route('admin.departments')->with('success', 'Department added successfully');
    }
    public function editDepartment(Request $request, $id)
    {
        // Find the department
        $department = Department::find($id);

        // Check if the user has permission to edit this department
        if (auth('admin')->user()->role_id == 2) {
            // Staff can only edit their own departments
            if ($department->staff_id != auth('admin')->user()->id) {
                return redirect()->route('admin.departments')->with('error', 'You do not have permission to edit this department');
            }
        }
        // Super admin can edit all departments (system + staff-specific)

        $updateData = [
            'department_name' => $request->input('department_name'),
            'updated_by' => auth('admin')->user()->id
        ];

        // Allow super admin to change staff assignment
        if (auth('admin')->user()->role_id != 2) {
            $updateData['staff_id'] = $request->staff_id ?? null;
        }

        $department->update($updateData);
        return redirect()->route('admin.departments')->with('success', 'Department updated successfully');
    }
    public function departments()
    {
        // Add your logic for departments view
        // If user is staff (role_id = 2), show only their departments
        // If user is super admin, show all departments (system + staff-specific)
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isSuperAdmin = false;
            $isStaff = true;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            return redirect()->route('admin.login');
        }
        if (auth('admin')->user()->role_id == 2) {
            $department = Department::where('staff_id', auth('admin')->user()->id)->latest()->get();
            $staffList = collect();
        } else {
            $department = Department::latest()->get();
            // Get list of staff members for dropdown
            $staffList = User::where('role_id', 2)->where('created_by', $user->id)->whereNull('deleted_at')->get();
        }
        return view('admin.departments', compact('department', 'staffList')); // Example view path, adjust as per your structure
    }
    public function storeDesignation(Request $request)
    {
        // Validate the request
        $request->validate([
            'designation' => 'required|string|max:255',
            'department' => 'required',
            // Add validation for permissions if needed
        ]);
        // Create a new designation
        $designation = new Designation();
        $designation->department_id = $request->department;
        $designation->designation = $request->designation;
        $designation->created_by = auth('admin')->user()->id;

        // Set staff_id based on user role and form input
        if (auth('admin')->user()->role_id == 2) {
            // Staff can only create designations for themselves
            $designation->staff_id = auth('admin')->user()->id;
        } else {
            // Super admin can assign to specific staff or leave null for system designations
            $designation->staff_id = $request->staff_id ?? null;
        }

        $designation->save();

        return redirect()->route('admin.designations')->with('success', 'Designation added successfully');
    }
    public function editDesignation(Request $request, $id)
    {
        // Find the designation
        $designation = Designation::find($id);

        // Check if the user has permission to edit this designation
        if (auth('admin')->user()->role_id == 2) {
            // Staff can only edit their own designations
            if ($designation->staff_id != auth('admin')->user()->id) {
                return redirect()->route('admin.designations')->with('error', 'You do not have permission to edit this designation');
            }
        }
        // Super admin can edit all designations (system + staff-specific)

        $updateData = [
            'department_id' => $request->input('department'),
            'designation' => $request->input('designation'),
            'updated_by' => auth('admin')->user()->id
        ];

        // Allow super admin to change staff assignment
        if (auth('admin')->user()->role_id != 2) {
            $updateData['staff_id'] = $request->staff_id ?? null;
        }

        $designation->update($updateData);
        return redirect()->route('admin.designations')->with('success', 'Designation updated successfully');
    }

    public function designations()
    {
        // If user is staff (role_id = 2), show only their departments and designations
        // If user is super admin, show all departments and designations (system + staff-specific)
        if (auth()->check()) {
            // Staff user from users table
            $user = auth()->user();
            $isSuperAdmin = false;
            $isStaff = true;
        } elseif (auth('admin')->check()) {
            // Admin user from admins table
            $user = Auth::guard('admin')->user();
            $isSuperAdmin = $user->hasRole('SuperAdmin');
            $isStaff = false;
        } else {
            return redirect()->route('admin.login');
        }
        if (auth('admin')->user()->role_id == 2) {
            $department = Department::where('staff_id', auth('admin')->user()->id)->latest()->get();
            $designation = Designation::where('staff_id', auth('admin')->user()->id)->latest()->get();
            $staffList = collect();
        } else {
            $department = Department::latest()->get();
            $designation = Designation::latest()->get();
            // Get list of staff members for dropdown
            $staffList = User::where('role_id', 2)->where('created_by', $user->id)->whereNull('deleted_at')->get();
        }
        // Add your logic for designations view
        return view('admin.designations', compact('designation', 'department', 'staffList')); // Example view path, adjust as per your structure
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
        $employeeId = $request->input('employee_id');
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }

        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'note' => $request->input('note'),
            'no_of_days' => $request->input('no_of_days'),
            'attachment' => $path,
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
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

        $employeeId = $request->input('employee_id');
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Check if any leave overlaps with the requested range
        $overlappingLeaves = EmployeeLeave::where('employee_id', $employeeId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from', [$fromDate, $toDate])
                    ->orWhereBetween('to', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from', '<=', $fromDate)
                                ->where('to', '>=', $toDate);
                    });
            })
            ->get();

        if ($overlappingLeaves->isNotEmpty()) {
            // Collect overlapping dates
            $overlappingDates = [];
            foreach ($overlappingLeaves as $leave) {
                $overlappingDates[] = $leave->from . ' to ' . $leave->to;
            }


            return redirect()->back()->with([
                'showModal' => true,
                'modalMessage' => 'The requested leave overlaps with existing leaves: ' . implode(', ', $overlappingDates),
            ]);
        }

        EmployeeLeave::create([
            'employee_id' => $request->input('employee_id'),
            'leave_type' => $request->input('leave_type'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'no_of_days' => $request->input('no_of_days'),
            'absence_series' => $request->input('absence_series'),
            'note' => $request->input('note'),
            'representation' => $request->input('representation'),
            'status' => 1,
            'created_by' =>  auth('admin')->user()->id,
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
        $departments = User::whereNotNull('department')->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')
            ->select('department')
            ->distinct()
            ->pluck('department');

        return response()->json(['departments' => $departments]);
    }
    public function getEmployeesByUsers($user_id)
    {
        $users = User::where('id', $user_id)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get();

        foreach ($users as $user) {
            $employeeLeaves = DB::table('employee_leaves')
            ->join('leave_types', 'employee_leaves.leave_type', '=', 'leave_types.name')
            ->where('employee_leaves.employee_id', $user->id)
            ->where('employee_leaves.status', 3)
            ->select('employee_leaves.*', 'leave_types.color')
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
        $users = User::where('department', $department)->where('users.created_by', auth('admin')->user()->id)->whereNull('deleted_at')->get();

        foreach ($users as $user) {
            $employeeLeaves = DB::table('employee_leaves')
            ->join('leave_types', 'employee_leaves.leave_type', '=', 'leave_types.name')
            ->where('employee_leaves.employee_id', $user->id)
            ->where('employee_leaves.status', 3)
            ->where('leave_types.created_by', '=', auth('admin')->user()->id)
            ->select('employee_leaves.*', 'leave_types.color')
            ->get();

            $leaveDays = [];
            $leavesData = [];
            $currentMonth = Carbon::now()->month;
            foreach ($employeeLeaves as $leave) {
                $leavesData[] = $leave;
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
            $user->leavesData = $leavesData;
        }

        return response()->json(['users' => $users]);
    }

    /**
     * Update module access for an employee
     */
    public function updateModuleAccess(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:users,id',
                'module' => 'sometimes|string',
                'module_name' => 'sometimes|string',
                'access' => 'sometimes|boolean',
                'has_access' => 'sometimes|boolean',
                'can_view' => 'sometimes|boolean',
                'can_create' => 'sometimes|boolean',
                'can_edit' => 'sometimes|boolean',
                'can_delete' => 'sometimes|boolean',
                'permissions' => 'sometimes|array'
            ]);

            $userId = $request->input('employee_id');
            $moduleName = $request->input('module') ?? $request->input('module_name');
            $hasAccess = $request->input('access') ?? $request->input('has_access', false);
            $submodulePermissions = $request->input('permissions', []);

            // Build permissions array
            $permissions = [
                'can_view' => $request->input('can_view', false),
                'can_create' => $request->input('can_create', false),
                'can_edit' => $request->input('can_edit', false),
                'can_delete' => $request->input('can_delete', false)
            ];

            // Find or create the module permission record
            $modulePermission = ModulePermission::updateOrCreate(
                [
                    'employee_id' => $userId,
                    'module_name' => $moduleName
                ],
                [
                    'has_access' => $hasAccess,
                    'can_view' => $permissions['can_view'],
                    'can_create' => $permissions['can_create'],
                    'can_edit' => $permissions['can_edit'],
                    'can_delete' => $permissions['can_delete'],
                    'permissions' => $permissions
                ]
            );

            // Handle submodule permissions separately if provided
            if (!empty($submodulePermissions)) {
                foreach ($submodulePermissions as $submoduleKey => $submoduleData) {
                    ModulePermission::updateOrCreate(
                        [
                            'employee_id' => $userId,
                            'module_name' => $submoduleKey
                        ],
                        [
                            'has_access' => ($submoduleData['can_view'] ?? false) || ($submoduleData['can_create'] ?? false) || ($submoduleData['can_edit'] ?? false) || ($submoduleData['can_delete'] ?? false),
                            'can_view' => $submoduleData['can_view'] ?? false,
                            'can_create' => $submoduleData['can_create'] ?? false,
                            'can_edit' => $submoduleData['can_edit'] ?? false,
                            'can_delete' => $submoduleData['can_delete'] ?? false,
                            'permissions' => $submoduleData
                        ]
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Module access updated successfully',
                'data' => $modulePermission
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating module access: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get module permissions for an employee
     */
    public function getEmployeeModulePermissions($employeeId)
    {
        try {
            $permissions = ModulePermission::where('employee_id', $employeeId)
                ->get()
                ->map(function ($permission) {
                    $data = [
                        'module_name' => $permission->module_name,
                        'has_access' => (bool) $permission->has_access,
                        'can_view' => (bool) $permission->can_view,
                        'can_create' => (bool) $permission->can_create,
                        'can_edit' => (bool) $permission->can_edit,
                        'can_delete' => (bool) $permission->can_delete,
                    ];

                    // Add nested permissions if they exist in the JSON field
                    if ($permission->permissions && is_array($permission->permissions)) {
                        foreach ($permission->permissions as $key => $submoduleData) {
                            $data[$key] = $submoduleData;
                        }
                    }

                    return $data;
                })
                ->keyBy('module_name');

            return response()->json([
                'success' => true,
                'data' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching module permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available modules list
     */
    public function getAvailableModules()
    {
        // Get main modules from permissions table (those without dots)
        $allPermissions = Permission::where('guard_name', 'web')->get();
        $mainModules = [];
        
        foreach ($allPermissions as $permission) {
            // Extract main module name (before the first dot)
            $moduleName = explode('.', $permission->name)[0];
            
            // Only add if it's not already in the array and it's a main module
            if (!in_array($moduleName, $mainModules) && !str_contains($permission->name, '.')) {
                $mainModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
            }
        }
        
        // Sort modules alphabetically
        asort($mainModules);

        return response()->json([
            'success' => true,
            'data' => $mainModules
        ]);
    }
}
