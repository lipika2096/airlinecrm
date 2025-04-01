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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{

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

        return view('admin.customer-profile', compact('customerConversation','customer', 'customerAccounts', 'customerAddress', 'customerContact', 'caseData', 'customerAccountBal', 'roles'));
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

}
