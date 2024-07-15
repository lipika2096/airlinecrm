<?php

namespace App\Http\Controllers\dashboard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calender; // Import Event model

class AppController extends Controller
{
    public function calendar()
    {
        $events = Calender::all(); // Assuming Event is the correct model name
        return view('admin.events', compact('events')); // Ensure the view path is correct
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
            'category' => $request->input('category'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Event added successfully.');
    }
}
