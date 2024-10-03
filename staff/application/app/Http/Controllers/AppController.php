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
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
        ]);

        $formattedDate = Carbon::parse($request->date)->format('Y-m-d');

        Calender::create([
            'name' => $request->name,
            'date' => $formattedDate,
            'category' => $request->category,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Event added successfully.');
    }
}
