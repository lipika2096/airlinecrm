<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesLead;
use App\Models\Client;
use App\Models\User;
use App\Models\AssignLeadStaff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalesLeadController extends Controller
{
    public function index()
    {
        // Fetch sales leads with assigned staff names
    $allocatedsalesLead = SalesLead::leftJoin('assign_lead_staffs', function ($join) {
        $join->on('sales_leads.id', '=', 'assign_lead_staffs.lead_id')
             ->where('assign_lead_staffs.status', 1);
    })
    ->leftJoin('users', 'assign_lead_staffs.staff_id', '=', 'users.id')
    ->select(
        'sales_leads.*',
        DB::raw('GROUP_CONCAT(CONCAT(users.first_name, " ", users.last_name) SEPARATOR ", ") as staff_names')
    )
    ->groupBy('sales_leads.id')->havingRaw('staff_names IS NOT NULL AND staff_names != ""')
    ->orderBy('sales_leads.created_at', 'desc')
    ->get();
    $unallocatedsalesLead = SalesLead::leftJoin('assign_lead_staffs', function ($join) {
        $join->on('sales_leads.id', '=', 'assign_lead_staffs.lead_id')
             ->where('assign_lead_staffs.status', 1);
    })
    ->leftJoin('users', 'assign_lead_staffs.staff_id', '=', 'users.id')
    ->select(
        'sales_leads.*',
        DB::raw('GROUP_CONCAT(CONCAT(users.first_name, " ", users.last_name) SEPARATOR ", ") as staff_names')
    )
    ->groupBy('sales_leads.id')
    ->havingRaw('staff_names IS NULL OR staff_names = ""') // Only include leads without staff_names
    ->orderBy('sales_leads.created_at', 'desc')
    ->get();
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
        return view('admin.sales_lead', compact('unallocatedsalesLead','allocatedsalesLead', 'salesLead', 'allEmployee')); // Example view path, adjust as per your structure
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'staff' => 'nullable|array',
        ]);

        // Create a new Sales Lead
        $salesLead = SalesLead::create([
            'company_name' => $request->input('company_name') ?? 'null',
            'website' => $request->input('website') ?? 'null',
            'email_id' => $request->input('email') ?? 'null',
            'phone' => $request->input('phone') ?? 'null',
            'contact_person' => $request->input('contact_person') ?? 'null',
            'category' => $request->input('category') ?? 'null',
            'remarks' => $request->input('remarks') ?? 'null',
            'created_by' => auth()->user()->name,
            'updated_at' => now(),
            'unique_id' => Str::uuid()->toString()
        ]);

        // Save data to the assignstaffs table if staff data is provided
        if ($request->has('staff')) {
            foreach ($request->input('staff') as $staffId => $status) {
                AssignLeadStaff::updateOrCreate(
                    [
                        'lead_id' => $salesLead->id, // Use the newly created Sales Lead ID
                        'staff_id' => $staffId,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }

        return redirect()->route('admin.saleslead')->with('success', 'Sales Lead added successfully');
    }

    public function update(Request $request, $id)
    {
        $saleslead = SalesLead::find($id);

        // Update the sales lead data
        $saleslead->update([
            'company_name' => $request->input('company_name') ?? 'null',
            'website' => $request->input('website') ?? 'null',
            'email_id' => $request->input('email') ?? 'null',
            'phone' => $request->input('phone') ?? 'null',
            'contact_person' => $request->input('contact_person') ?? 'null',
            'category' => $request->input('category') ?? 'null',
            'remarks' => $request->input('remarks') ?? 'null',
            'updated_by' => auth()->user()->name,
        ]);

        // Get the current assigned staff for this sales lead
        $currentAssignedStaff = AssignLeadStaff::where('lead_id', $id)->pluck('staff_id')->toArray();

        // Get the staff from the submitted form data
        $submittedStaff = $request->input('staff', []);

        // Remove staff that are unchecked (not in the submitted list)
        $removedStaff = array_diff($currentAssignedStaff, array_keys($submittedStaff));
        if ($removedStaff) {
            AssignLeadStaff::whereIn('staff_id', $removedStaff)
                ->where('lead_id', $id)
                ->delete(); // Remove the staff from the assignment
        }

        // Add new staff or update existing staff
        foreach ($submittedStaff as $staffId => $status) {
            AssignLeadStaff::updateOrCreate(
                [
                    'lead_id' => $id,
                    'staff_id' => $staffId,
                ],
                [
                    'status' => $status,
                ]
            );
        }

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
