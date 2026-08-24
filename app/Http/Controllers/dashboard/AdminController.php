<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\AdminDetail;
use App\Models\AdminKycDocument;
use App\Models\CustomerAccount;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\SalesPackage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'full_name' => 'required',
            'company_name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'modules' => 'required',
        ]);

        // Auto-generate unique password based on user details
        $symbols = ['@', '#', '$', '%', '&', '*', '!', '?'];
        $randomSymbol = $symbols[array_rand($symbols)];
        
        $defaultPassword = strtoupper(substr($request->input('full_name'), 0, 3)) . 
                           $randomSymbol . 
                           substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3) . 
                           rand(100, 999);

        $admin = Admin::create([
            'email' =>  $request->input('email'),
            'password' =>  Hash::make($defaultPassword),
            'name' =>  $request->input('full_name'),
            'plain_password' => $defaultPassword,
            'is_active' => true
        ]);

        // Send password to user email with reset link
        try {
            $resetLink = url('/forgot-password');
            \Mail::raw("Hello {$request->input('full_name')},\n\nYour account has been created successfully.\n\nYour login credentials:\nEmail: {$request->input('email')}\nTemporary Password: {$defaultPassword}\n\nFor security, we recommend changing your password after first login.\n\nIf you need to reset your password, visit: {$resetLink}\n\nThank you.", function($message) use ($request) {
                $message->to($request->input('email'))
                        ->subject('Your Account Credentials');
            });
        } catch (\Exception $e) {
            // Log error but don't prevent user creation
            \Log::error('Failed to send email: ' . $e->getMessage());
        }
        $subscriptionCharge = $request->input('subscription_charge');
        $paymentType = $request->input('payment_type', 'base');
        $salesPackageId = $request->input('sales_package');
        $activationDate = $request->input('package_activation_date');

        // Calculate subscription expiry date based on payment type
        $expiryDate = null;
        if ($paymentType === 'monthly') {
            $expiryDate = Carbon::now()->addMonth()->format('Y-m-d');
        } elseif ($paymentType === 'annual') {
            $expiryDate = Carbon::now()->addYear()->format('Y-m-d');
        }
        // For base rate, no expiry date

        AdminDetail::create([
            'company_name' =>  $request->input('company_name'),
            'city' =>  $request->input('city'),
            'state' =>  $request->input('state'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'admin_id' => $admin->id,
            'group' => $request->input('group'),
            'pincode' => $request->input('pincode'),
            'company_registration_no' => $request->input('company_registration_no'),
            'no_modules' => $request->input('no_modules'),
            'subscription_type' => $salesPackageId,
            'subscription_charge' => $subscriptionCharge,
            'payment_type' => $paymentType,
            'package_activation_date' => $activationDate,
            'subscription_expiring' => $expiryDate,
            'business_focus' =>json_encode($request->focus_destinations),
            'remarks' => $request->input('remarks'),
            'business_mode' => $request->input('business_mode'),
            'key_people' => $request->input('key_people'),
            'parent_company' => $request->input('parent_company'),
            'headquarters' => $request->input('headquarters'),
            'no_employees' => $request->input('no_employees'),
            'websites' => json_encode($request->websites),
        ]);

        // Calculate and create automatic debit entry for package activation
        if ($salesPackageId && $subscriptionCharge) {
            $package = SalesPackage::find($salesPackageId);
            $currentDate = Carbon::now();
            
            if ($paymentType === 'monthly') {
                // Monthly: Prorated for remaining days in current month
                $daysInMonth = $currentDate->daysInMonth;
                $currentDay = $currentDate->day;
                $remainingDays = $daysInMonth - $currentDay + 1;
                
                $dailyRate = $subscriptionCharge / $daysInMonth;
                $proratedAmount = round($dailyRate * $remainingDays, 2);
                
                $description = 'Package Activation - ' . ($package ? $package->package_name : 'Unknown') . ' (Monthly - Prorated for ' . $remainingDays . ' days)';
            } elseif ($paymentType === 'annual') {
                // Annual: Prorated for remaining days in current year
                $daysInYear = $currentDate->isLeapYear() ? 366 : 365;
                $currentDayOfYear = $currentDate->dayOfYear;
                $remainingDays = $daysInYear - $currentDayOfYear + 1;
                
                $dailyRate = $subscriptionCharge / $daysInYear;
                $proratedAmount = round($dailyRate * $remainingDays, 2);
                
                $description = 'Package Activation - ' . ($package ? $package->package_name : 'Unknown') . ' (Annual - Prorated for ' . $remainingDays . ' days)';
            } else {
                // Base: Full amount charged immediately
                $proratedAmount = $subscriptionCharge;
                $description = 'Package Activation - ' . ($package ? $package->package_name : 'Unknown') . ' (Base Rate)';
            }

            // Create automatic debit entry
            CustomerAccount::create([
                'customer_id' => $admin->id,
                'debit' => $proratedAmount,
                'credit' => 0,
                'tr_date' => $activationDate,
                'tr_type' => $description,
                'balance' => -$proratedAmount
            ]);
        }

        // $role = Role::findById($request->input('role'),'web');
        // $admin->assignRole($role);
        
        // Handle multiple modules selection
        if ($request->has('modules')) {
            $modules = $request->input('modules');
            if (count($modules) === 1 && is_string($modules[0])) {
        $modules = json_decode($modules[0], true);
    }

            foreach ($modules as $moduleId) {
                $module = Permission::findById($moduleId, 'web');
                $admin->givePermissionTo($module);
            }
        }
        return redirect()->route('admin.admin.view')->with('success', 'New Admin created successfully');
    }

    public function showAllAdmin(Request $request){
        $admin = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        $modules = Permission::where('guard_name', 'web')->get();
        $salesPackages = SalesPackage::get();
        return view('admin.admin-view', compact('admin', 'roles', 'modules', 'salesPackages'));
    }

    public function addCustomer(Request $request){
        $admin = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        $modules = Permission::where('guard_name', 'web')->get();
        $salesPackages = SalesPackage::get();
        return view('admin.customer-add', compact('admin', 'roles', 'modules', 'salesPackages'));
    }

    public function editAdmin(Request $request, $id){
        $admin = Admin::find($id);
        $admin->update([
            'name' => $request->full_name
        ]);
        if ($request->has('role')) {
            $admin->syncRoles($request->role);
        }
        
        // Handle multiple modules selection in edit
        if ($request->has('modules')) {
            $modules = $request->input('modules');
            $admin->syncPermissions($modules);
        }

        $admin_detail = AdminDetail::where('admin_id', $id)->first();
        if($admin_detail == null){
            AdminDetail::create([
                'company_name' =>  $request->input('company_name'),
                'city' =>  $request->input('city'),
                'state' =>  $request->input('state'),
                'country' => $request->input('country'),
                'address' => $request->input('address'),
                'admin_id' => $id,
            ]);
        }
        else{
            $admin_detail->update([
                'company_name' =>  $request->input('company_name'),
                'city' =>  $request->input('city'),
                'state' =>  $request->input('state'),
                'country' => $request->input('country'),
                'address' => $request->input('address'),
                'group' => $request->input('group'),
                'pincode' => $request->input('pincode'),
                'company_registration_no' => $request->input('company_registration_no'),
                'no_modules' => $request->input('no_modules'),
                'subscription_type' => $request->input('subscription_type'),
                'subscription_charge' => $request->input('subscription_charge'),
                'payment_type' => $request->input('payment_type', 'base'),
                'package_activation_date' => $request->input('package_activation_date') ?? $admin_detail->package_activation_date,
                'subscription_expiring' => $request->input('subscription_expiring'),
                'business_focus' =>json_encode($request->focus_destinations)??json_encode(['-']),
                'remarks' => $request->input('remarks'),
                'business_mode' => $request->input('business_mode'),
                'key_people' => $request->input('key_people'),
                'parent_company' => $request->input('parent_company'),
                'headquarters' => $request->input('headquarters'),
                'no_employees' => $request->input('no_employees'),
                'websites' => json_encode($request->websites)??json_encode(['-']),
            ]);
        }
        return redirect()->back()->with('success', 'Admin updated successfully');
    }

    public function kycDocumentIndex(Request $request){
        $admin =Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->get();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        return view('admin.admin-kyc', compact('admin', 'roles'));
    }

    public function kycDocument(Request $request, $id){
        $fileNames = [];

        if ($request->hasFile('doc_file')) {
            foreach ($request->file('doc_file') as $docFile) {
                $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();
                $storagePath = 'public/assets/docs/';

                // Ensure directory exists
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true, true);
                }

                // Store file
                $docFile->move($storagePath, $fileName);

                // Store the file path in array
                $fileNames[] = asset('public/assets/docs/' . $fileName);
            }
        }

        // Save the file names as JSON
        AdminKycDocument::create([
            'admin_id' => $id,
            'doc_name' => $request->input('doc_name'),
            'doc_file' => json_encode($fileNames),
            'remarks' => $request->input('remarks'),
        ]);

        return redirect()->back()->with('success', 'Documents uploaded successfully');
    }


    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
          ]);
          $credentials = $request->only('email', 'password');
          // Attempt to log the user in
          if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            
            // Check if user is active
            if ($admin->is_active == 0) {
                Auth::guard('admin')->logout();
                return redirect()
                    ->back()
                    ->with('error', 'Your account is deactivated. Please contact administrator.');
            }
            
            // Check if user does NOT have superAdmin role - deny access
            if (!$admin->hasRole('SuperAdmin')) {
                // Auth::guard('admin')->logout();
                return redirect()
                    ->back()
                    ->with('error', 'Only SuperAdmin can use the Admin login tab.');
            }
            
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('email', $admin->email);
            $request->session()->put('role', 'Superadmin');

            return redirect('/superadmin/dashboard');
          }

          // If unsuccessful, then redirect back to the login with the form data
          // If unsuccessful, then redirect back to the login with the form data
          return redirect()
            ->back()
            ->with('error', 'These credentials do not match our records.');
    }

    public function staffLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
          ]);
          $credentials = $request->only('email', 'password');
          // Attempt to log the user in
          if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            
            // Check if user is inactive
            if ($admin->is_active == 0) {
                Auth::guard('admin')->logout();
                return redirect()
                    ->back()
                    ->with('error', 'Your account is deactivated. Please contact administrator.');
            }
            
            // Check if user has superAdmin role - deny access
            if ($admin->hasRole('SuperAdmin')) {
                return redirect()
                    ->back()
                    ->with('error', 'SuperAdmin users must use the Admin login tab.');
            }
            
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('email', $admin->email);
            $request->session()->put('role', 'Customer');

            return redirect('/customer/dashboard');
          }

          // If unsuccessful, then redirect back to the login with the form data
          // If unsuccessful, then redirect back to the login with the form data
          return redirect()
            ->back()
            ->with('error', 'These credentials do not match our records.');
    }
    public function toggleStatus($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->is_active = !$admin->is_active;
            $admin->save();
            return redirect()->back()->with('success', 'User status updated successfully.');
        }
        return redirect()->back()->with('error', 'User not found.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Log the admin out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('admin.login'); // Redirect to the login page
    }

    public function staffLogout(Request $request)
    {
        Auth::guard('admin')->logout(); // Log the admin out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('admin.login'); // Redirect to the login page
    }

}
