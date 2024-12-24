<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesLead;
use App\Models\Client;
use App\Models\User;
use App\Models\AssignLeadStaff;
use Illuminate\Support\Facades\DB;

class SalesLeadController extends Controller
{
    public function index()
    {
        // Fetch sales leads with assigned staff names
    $salesLead = SalesLead::leftJoin('assign_lead_staffs', function ($join) {
        $join->on('sales_leads.id', '=', 'assign_lead_staffs.lead_id')
             ->where('assign_lead_staffs.status', 1);
    })
    ->leftJoin('users', 'assign_lead_staffs.staff_id', '=', 'users.id')
    ->select(
        'sales_leads.*',
        DB::raw('GROUP_CONCAT(CONCAT(users.first_name, " ", users.last_name) SEPARATOR ", ") as staff_names')
    )
    ->groupBy('sales_leads.id')
    ->orderBy('sales_leads.created_at', 'desc')
    ->get();
        $allEmployee = Client::join('users', 'users.clientid', '=', 'clients.client_id')
        ->get(['clients.*', 'users.*']);
        // Add your logic for lead index view
        return view('admin.sales_lead', compact('salesLead', 'allEmployee')); // Example view path, adjust as per your structure
    }
    public function store(Request $request)
    {
        // Create a new employee
        SalesLead::create([
            'company_name' => $request->input('company_name')??'null',
            'website' => $request->input('website')??'null',
            'email_id' => $request->input('email')??'null',
            'phone' => $request->input('phone')??'null',
            'contact_person' => $request->input('contact_person')??'null',
            'category' => $request->input('category')??'null',
            'remarks' => $request->input('remarks')??'null',
        ]);

        return redirect()->route('admin.saleslead')->with('success', 'Sales Lead added successfully');
    }
    public function update(Request $request, $id)
    {
        // Create a new employee
        $saleslead =  SalesLead::find($id);
        $saleslead->update([
            'company_name' => $request->input('company_name')??'null',
            'website' => $request->input('website')??'null',
            'email_id' => $request->input('email')??'null',
            'phone' => $request->input('phone')??'null',
            'contact_person' => $request->input('contact_person')??'null',
            'category' => $request->input('category')??'null',
            'remarks' => $request->input('remarks')??'null',
        ]);
        return redirect()->route('admin.saleslead')->with('success', 'Sales Lead updated successfully');
    }

    // Add other methods as per your defined routes
    public function assignStaff(Request $request)
    {
        foreach ($request->input('staff') as $staffId => $salesLead) {
            foreach ($salesLead as $salesLead => $status) {

                AssignLeadStaff::updateOrCreate(
                    [
                        'lead_id' => $salesLead,
                        'staff_id' => $staffId
                    ],
                    [
                        'status' => $status
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Lead Assigned to staff updated successfully.');
    }
}
