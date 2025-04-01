<?php

namespace App\Http\Controllers\dashboard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calender; // Import Event model
use App\Models\EventStatus;
use App\Models\SalesLead;
use App\Models\AssignLeadStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function calendar()
    {
        $username = auth('admin')->user()->id;

        $events = Calender::where('created_by',$username)->get(); // Assuming Event is the correct model name
        $eventStatus = EventStatus::orderBy('status_type')->get();
        $salesLead = SalesLead::leftJoin('assign_lead_staffs', function ($join) {
            $join->on('sales_leads.id', '=', 'assign_lead_staffs.lead_id')
                 ->where('assign_lead_staffs.status', 1);
        })
        ->leftJoin('users', 'assign_lead_staffs.staff_id', '=', 'users.id')
        ->select(
            'sales_leads.*',
            DB::raw('GROUP_CONCAT(CONCAT(users.first_name, " ", users.last_name) SEPARATOR ", ") as staff_names')
        )
        ->groupBy('sales_leads.id')->havingRaw('staff_names IS NOT NULL AND staff_names != ""')
        ->orderBy('sales_leads.created_at', 'desc')->where('sales_leads.created_by', auth('admin')->user()->name)
        ->get();
        $combinedData = collect($events)->merge($salesLead);
        return view('admin.events', compact('combinedData', 'eventStatus')); // Ensure the view path is correct
    }



    public function store(Request $request)
    {
        // $request->validate([
        //     'event_name' => 'required|string|max:255',
        //     'event_date' => 'required|date',
        //     'category' => 'required|string|max:255',
        // ]);

         // Format the date to Y-m-d
    // $formattedDate = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');
        Calender::create([
            'event_name' => $request->input('event_name'),
            'event_date' => $request->input('event_date'),
            'website' => $request->input('website'),
            'email_id' => $request->input('email_id'),
            'phone_no' => $request->input('phone_no'),
            'contact_person' => $request->input('contact_person'),
            'remarks' => $request->input('remarks'),
            'updated_at' => $request->input('updated_at'),
            'created_by' => auth('admin')->user()->id,
            'category' => $request->input('category')
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Event added successfully.');
    }
    public function update(Request $request, $id){
        $eventStatus = Calender::find($id);
        $salesLead = SalesLead::where('unique_id',$id);
        if($eventStatus !== null){
            $eventStatus->update([
                'status' => $request->input('status'),
                'updated_by' => auth('admin')->user()->id,
                'updated_at' => now()
            ]);
        }
        else{
            $salesLead->update([
                'status' => $request->input('status'),
                'updated_by' => auth('admin')->user()->id,
                'updated_at' => now()
            ]);
        }
        return redirect()->back()->with('success', 'Event status updated successfully.');
    }
}
