<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\CustomerCaseHistory;
use App\Models\CustomerCaseUpdate;
use App\Models\CustomerAccount;
use App\Models\CustomerAddress;
use App\Models\CustomerHeadOfficeContactDetail;
use App\Models\Designation;
use App\Models\CustomerConversation;
use App\Models\SalesPackage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    public function updatePermission(Request $request)
{
    $request->validate([
        'customer_id' => 'required|integer',
        'permission_id' => 'required|integer',
        'assign' => 'required',
    ]);

    $customer = Admin::find($request->customer_id);
    $permission = Permission::find($request->permission_id);
    $assign = filter_var($request->assign, FILTER_VALIDATE_BOOLEAN);
    if (!$customer || !$permission) {
        return response()->json(['message' => 'Invalid customer or permission.'], 400);
    }
    if ($assign) {
        // Assign permission
        $customer->givePermissionTo($permission);
        return response()->json(['message' => 'Permission assigned successfully.']);
    } else {
        // Remove permission
        DB::table('model_has_permissions')
            ->where('model_id', $customer->id)
            ->where('permission_id', $permission->id)
            ->where('model_type', 'App\Models\Admin') // make sure this matches your Customer model
            ->delete();

        return response()->json(['message' => 'Permission removed successfully.']);
    }
}


    public function customerProfile(Request $request, $id)
    {

        $customer = Admin::with(['adminDetail', 'kycDocuments'])->find($id);
        $customerAccounts = CustomerAccount::where('customer_id', $id)->where('acc_no', Null)->get();
        $customerAccountBal = CustomerAccount::where('customer_id', $id)->where('acc_no', '!=', Null)->first();
        $customerAddress = CustomerAddress::where('customer_id', $id)->get();
        $customerContact = CustomerHeadOfficeContactDetail::where('customer_id', $id)->get();
        $customerConversation = CustomerConversation::where('customer_id', $id)->get();

        $caseData = CustomerCaseHistory::where('customer_id', $id)->get();
        $designation = Designation::all();
        $roles = Role::with('permissions')->where('name', '!=', 'superAdmin')->get();
        $salesPackages = SalesPackage::where('is_active', true)->get();

        return view('admin.customer-profile', compact('customerConversation','customer', 'customerAccounts', 'customerAddress', 'customerContact', 'caseData', 'customerAccountBal', 'roles', 'salesPackages'));
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'sales_package' => 'required|integer|exists:sales_packages,id',
            'payment_type' => 'required|in:base,monthly,annual',
            'subscription_charge' => 'required|numeric|min:0',
        ]);

        $customer = Admin::find($id);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $package = SalesPackage::find($request->sales_package);
        if (!$package) {
            return redirect()->back()->with('error', 'Package not found.');
        }

        // Check if customer is changing to a different package
        $currentPackageId = $customer->adminDetail->subscription_type ?? null;
        $isPackageChange = $currentPackageId != $package->id;

        // If changing package, validate it's the 1st of current month
        if ($isPackageChange) {
            $currentDate = Carbon::now();
            if ($currentDate->day !== 1) {
                return redirect()->back()->with('error', 'Package changes can only be processed on the 1st day of the month. Please try again on the 1st.');
            }
        }
        if($currentPackageId == $package->id && $request->package_activation_date){
            $currentDate = Carbon::now();
            if ($currentDate->day !== 1) {
                return redirect()->back()->with('error', 'Package changes can only be processed on the 1st day of the month. Please try again on the 1st.');
            }
        }
        // Auto-set activation date to current date
        $activationDate = $request->package_activation_date;

        // Calculate subscription expiry date based on payment type
        $expiryDate = null;
        if ($request->payment_type === 'monthly') {
            $expiryDate = Carbon::now()->addMonth()->format('Y-m-d');
        } elseif ($request->payment_type === 'annual') {
            $expiryDate = Carbon::now()->addYear()->format('Y-m-d');
        }
        // For base rate, no expiry date

        // Remove all existing permissions from the customer
        DB::table('model_has_permissions')
            ->where('model_id', $customer->id)
            ->where('model_type', 'App\Models\Admin')
            ->delete();

        // Update customer's subscription type, charge, payment type, and auto-set activation date
        if ($customer->adminDetail) {
            $customer->adminDetail->update([
                'subscription_type' => $package->id,
                'subscription_charge' => $request->subscription_charge,
                'payment_type' => $request->payment_type,
                'package_activation_date' => $activationDate,
                'subscription_expiring' => $expiryDate,
            ]);
        } else {
            // Create admin detail if it doesn't exist
            $customer->adminDetail()->create([
                'subscription_type' => $package->id,
                'subscription_charge' => $request->subscription_charge,
                'payment_type' => $request->payment_type,
                'package_activation_date' => $activationDate,
                'subscription_expiring' => $expiryDate,
            ]);
        }

        // Assign new permissions based on the package's modules
        if (!empty($package->modules) && is_array($package->modules)) {
            foreach ($package->modules as $permissionId) {
                $permission = Permission::find($permissionId);
                if ($permission) {
                    $customer->givePermissionTo($permission);
                }
            }
        }

        // Calculate prorated amount based on payment type and add as debit
        $currentDate = Carbon::now();
        $subscriptionCharge = $request->subscription_charge;
        $paymentType = $request->payment_type;
        
        if ($paymentType === 'monthly') {
            // Monthly: Prorated for remaining days in current month
            $daysInMonth = $currentDate->daysInMonth;
            $currentDay = $currentDate->day;
            $remainingDays = $daysInMonth - $currentDay + 1; // +1 to include current day
            
            $dailyRate = $subscriptionCharge / $daysInMonth;
            $proratedAmount = round($dailyRate * $remainingDays, 2);
            
            $description = 'Package Activation - ' . $package->package_name . ' (Monthly - Prorated for ' . $remainingDays . ' days)';
        } elseif ($paymentType === 'annual') {
            // Annual: Prorated for remaining days in current year
            $daysInYear = $currentDate->isLeapYear() ? 366 : 365;
            $currentDayOfYear = $currentDate->dayOfYear;
            $remainingDays = $daysInYear - $currentDayOfYear + 1;
            
            $dailyRate = $subscriptionCharge / $daysInYear;
            $proratedAmount = round($dailyRate * $remainingDays, 2);
            
            $description = 'Package Activation - ' . $package->package_name . ' (Annual - Prorated for ' . $remainingDays . ' days)';
        } else {
            // Base: Full amount charged immediately
            $proratedAmount = $subscriptionCharge;
            $description = 'Package Activation - ' . $package->package_name . ' (Base Rate)';
        }

        // Get the last balance for the customer
        $lastAccount = CustomerAccount::where('customer_id', $customer->id)->orderBy('id', 'desc')->first();
        $lastBalance = $lastAccount ? $lastAccount->balance : 0;

        // Create automatic debit entry for package activation
        CustomerAccount::create([
            'customer_id' => $customer->id,
            'debit' => $proratedAmount,
            'credit' => 0,
            'tr_date' => $activationDate,
            'tr_type' => $description,
            'balance' => $lastBalance - $proratedAmount
        ]);

        return redirect()->back()->with('success', 'Package updated successfully. Permissions and subscription charges have been updated. A debit entry of $' . number_format($proratedAmount, 2) . ' has been added to the customer account.');
    }

    public function caseHistorySearch(Request $request)
    {
        $customers = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->with(['kycDocuments', 'adminDetail'])->get();

        // Get input values from the request
        $caseId = $request->input('id');
        $pnr = $request->input('pnr');
        $ticket_no = $request->input('ticket_no');
        $status = $request->input('case_status');
        $openDate = $request->input('case_opening_date');
        $customer_id = $request->input('customer_id');

        // Start building the query
        $query = CustomerCaseHistory::query();

        // Apply filters based on the input values
        if ($caseId) {
            $query->where('id', $caseId);
        }

        if ($pnr) {
            $query->where('pnr', $pnr);
        }

        if ($ticket_no) {
            $query->where('ticket_no', $ticket_no);
        }

        if ($status) {
            $query->where('case_status', $status);
        }

        if ($openDate) {
            $query->whereDate('case_opening_date', $openDate);
        }

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        // Execute the query to get the filtered results
        $cases = $query->get();

        // Return the view with the filtered data
        return view('admin.customer-view-case-history', compact(
            'customers',
            'caseId',
            'pnr',
            'ticket_no',
            'status',
            'openDate',
            'customer_id',
            'cases'
        ));
    }

    public function caseStore(Request $request)
    {
        $validatedData = $request->validate([
            'case_opening_date' => 'required|date',
            'opened_by' => 'required|string|max:255',
            'pnr' => 'required|string|max:255',
            'case_status' => 'required|string|max:255',
            'case_closed_by' => 'nullable|string|max:255',
            'case_closing_date' => 'nullable|date',
            'customer_id' => 'required|integer',
            'remarks' => 'required|string',
            'ticket_no' => 'required|string'
        ]);

        $case = CustomerCaseHistory::create($validatedData);
        // Add the new update to the case_updates table
        CustomerCaseUpdate::create([
            'case_id' => $case->id,
            'update_date' => $request->input('case_opening_date'),
            'updated_by' => auth('admin')->user()->name,
            'comments' => $request->remarks,
            'status' => $request->input('case_status'),
        ]);

        return redirect()->back()->with('success', 'Case Created successfully.');
    }


    // Update the case based on the form submission
    public function caseUpdate(Request $request, $id)
    {
        $case = CustomerCaseHistory::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:Update,Close',
            'comments' => 'required|string|max:1000',
        ]);

        // Add the new update to the case_updates table
        CustomerCaseUpdate::create([
            'case_id' => $case->id,
            'update_date' => Carbon::now(),
            'updated_by' => auth('admin')->user()->name,
            'comments' => $request->comments,
            'status' => $request->status,
        ]);

        // Update the case status and other relevant fields if closing the case
        if ($request->status === 'Close') {
            $case->update([
                'case_status' => 'Closed',
                'case_closed_by' => auth('admin')->user()->name,
                'case_closing_date' => Carbon::now(),
            ]);
        } else {
            $case->update(['case_status' => 'Updated']);
        }

        return redirect()->back()->with('success', 'Case updated successfully.');
    }


    // Close the case
    public function caseClose(Request $request)
    {
        $case = CustomerCaseHistory::findOrFail($request->input('caseId'));

        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        // Update the case status to closed and record closing comments
        CustomerCaseUpdate::create([
            'case_id' => $case->id,
            'update_date' => Carbon::now(),
            'updated_by' => auth('admin')->user()->name,
            'comments' => $request->comments,
            'status' => 'Closed',
        ]);

        $case->update([
            'case_status' => 'Closed',
            'case_closed_by' => auth('admin')->user()->name,
            'case_closing_date' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Case Closed successfully.');
    }


    public function AddressStore(Request $request)
    {
        CustomerAddress::create([
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'street' => $request->input('street'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
            'customer_id' => $request->input('customer_id'),
            'created_by' => auth('admin')->user()->id
        ]);
        return redirect()->back()->with('success', 'Address created successfully.');
    }

    public function addressUpdate(Request $request, $id)
    {

        $prod = CustomerAddress::find($id);
        $prod->update([
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'street' => $request->input('street'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
            'updated_by' => auth('admin')->user()->id
        ]);
        return redirect()->back()->with('success', 'Address updated successfully.');
    }


    public function contactUpdate(Request $request, $id)
    {
        $prod = CustomerHeadOfficeContactDetail::find($id);
        $prod->update([
            'title' => $request->input('title'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email_address' => $request->input('email_address'),
            'phone_number' => $request->input('phone_number'),
            'position' => $request->input('position'),
            'add_to_mail_list' => $request->input('add_to_mail_list') == '1' ? 1 : 0,
            'last_updated_by' => auth('admin')->user()->id,
            'updated_by' => auth('admin')->user()->id
        ]);
        return redirect()->back()->with('success', 'Contact details updated successfully.');
    }

    public function contactDelete($id)
    {
        $contact = CustomerHeadOfficeContactDetail::find($id);
        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found.');
        }
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }
    public function ContactStore(Request $request)
    {
        CustomerHeadOfficeContactDetail::create([
            'title' => $request->input('title'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email_address' => $request->input('email_address'),
            'phone_number' => $request->input('phone_number'),
            'position' => $request->input('position'),
            'customer_id' => $request->input('customer_id'),
            'add_to_mail_list' => $request->input('add_to_mail_list'),
            'updated_at' => $request->input('updated_at'),
            'created_by' => auth('admin')->user()->id
        ]);
        return redirect()->back()->with('success', 'Contact details created successfully.');
    }
    public function conversationStore(Request $request)
    {
        CustomerConversation::create([
            'from' => $request->input('from'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'c_date' => now(),
            'customer_id' => $request->input('customer_id'),
            'date_of_contact' => $request->input('date_of_contact')
        ]);
        return redirect()->back();
    }

    public function transactionStore(Request $request)
    {

        // Get the last balance for the agent
        $lastAccount = CustomerAccount::where('customer_id', $request->customer_id)->orderBy('id', 'desc')->first();
        $lastBalance = $lastAccount ? $lastAccount->balance : 0;

        // Calculate new balance based on credit and debit
        $credit = $request->credit ? floatval($request->credit) : 0;
        $debit = $request->debit ? floatval($request->debit) : 0;
        $newBalance = $lastBalance + $credit - $debit;
        CustomerAccount::create([
            'customer_id' => $request->input('customer_id'),
            'debit' => $request->input('debit'),
            'credit' => $request->input('credit'),
            'tr_date' => $request->input('tr_date'),
            'tr_type' => $request->input('tr_type'),
            'balance' => $newBalance
        ]);
        return redirect()->back();
    }

}
