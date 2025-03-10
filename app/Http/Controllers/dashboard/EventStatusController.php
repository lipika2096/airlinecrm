<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventStatus;

class EventStatusController extends Controller{
    public function index(){
        $eventStatus = EventStatus::where('created_by', auth('admin')->user()->id)->latest()->get();
        return view('admin.event_status', compact('eventStatus'));
    }

    public function store(Request $request){
        EventStatus::create([
            'status_type' => $request->input('status'),
            'created_by' => auth('admin')->user()->id,
        ]);
        return redirect()->route('admin.events.status');
    }

    public function update(Request $request, $id){
        $eventStatus = EventStatus::find($id);
        $eventStatus->update([
            'status_type' => $request->input('status'),
            'upadted_by' => auth('admin')->user()->id,
        ]);
        return redirect()->route('admin.events.status');
    }

    public function delete(Request $request, $id){
        $eventStatus = EventStatus::find($id);
        $eventStatus->delete();
        return redirect()->route('admin.events.status');
    }
}
