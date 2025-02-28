<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\AdminDetail;
use App\Models\AdminKycDocument;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'full_name' => 'required',
            'company_name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
        ]);
        $admin = Admin::create([
            'email' =>  $request->input('email'),
            'password' =>  Hash::make($request->input('password')),
            'name' =>  $request->input('full_name'),
            'plain_password' => $request->password
        ]);
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
            'subscription_type' => $request->input('subscription_type'),
            'subscription_charge' => $request->input('subscription_charge'),
            'subscription_expiring' => $request->input('subscription_expiring'),
            'business_focus' =>json_encode($request->focus_destinations),
            'remarks' => $request->input('remarks'),
            'business_mode' => $request->input('business_mode'),
            'key_people' => $request->input('key_people'),
            'parent_company' => $request->input('parent_company'),
            'headquarters' => $request->input('headquarters'),
            'no_employees' => $request->input('no_employees'),
            'websites' => json_encode($request->websites),
        ]);

        $role = Role::findById($request->input('role'),'web');
        $admin->assignRole($role);

        return redirect()->back()->with('success', 'New Admin created successfully');
    }

    public function showAllAdmin(Request $request){
        $admin = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        return view('admin.admin-view', compact('admin', 'roles'));
    }

    public function editAdmin(Request $request, $id){
        $admin = Admin::find($id);
        $admin->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password
        ]);
        if ($request->has('role')) {
            $admin->syncRoles($request->role);
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
                'subscription_expiring' => $request->input('subscription_expiring'),
                'business_focus' =>json_encode($request->focus_destinations),
                'remarks' => $request->input('remarks'),
                'business_mode' => $request->input('business_mode'),
                'key_people' => $request->input('key_people'),
                'parent_company' => $request->input('parent_company'),
                'headquarters' => $request->input('headquarters'),
                'no_employees' => $request->input('no_employees'),
                'websites' => json_encode($request->websites),
            ]);
        }
        return redirect()->back()->with('success', 'Admin updated successfully');
    }

    public function kycDocumentIndex(Request $request){
        $admin = AdminKycDocument::with('admin')->latest()->get();
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
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('email', $admin->email);
            $request->session()->put('role', 'Superadmin');

            return redirect()->route('admin.dashboard');
          }

          // If unsuccessful, then redirect back to the login with the form data
          // If unsuccessful, then redirect back to the login with the form data
          return redirect()
            ->back()
            ->with('error', 'These credentials do not match our records.');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Log the admin out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return view('admin.index'); // Redirect to the login page
    }

}
