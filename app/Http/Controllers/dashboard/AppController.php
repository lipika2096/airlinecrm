<?php

namespace App\Http\Controllers\dashboard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calender; // Import Event model
use App\Models\EventStatus;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function calendar()
    {
        $events = Calender::where('created_by', auth()->user()->id)->get(); // Assuming Event is the correct model name
        $eventStatus = EventStatus::orderBy('status_type')->get();
        return view('admin.events', compact('events', 'eventStatus')); // Ensure the view path is correct
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
            'created_by' => auth()->user()->name,
            'category' => $request->input('category')
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Event added successfully.');
    }
    public function update(Request $request, $id){
        $eventStatus = Calender::find($id);
        $eventStatus->update([
            'status' => $request->input('status'),
            'updated_by' => auth()->user()->id,
            'updated_at' => now()
        ]);
        return redirect()->back()->with('success', 'Event added successfully.');
    }
}
