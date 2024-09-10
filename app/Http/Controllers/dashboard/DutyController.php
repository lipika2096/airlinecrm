<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Duty;
use Illuminate\Support\Facades\Validator;

class DutyController extends Controller
{
    public function duties()
    {
        $duties = Duty::all();
        return view('admin.duties', compact('duties'));
    }

    public function storeDuty(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'
        ]);

        $duty = new Duty();
        $duty->name = $request->name;
        $duty->save();

        return redirect()->route('admin.duties')->with('success', 'Duty created successfully.');
    }

    public function updateDuty(Request $request, $id)
    {
        $duty = Duty::findorFail($id);
        $duty->name = $request->name;
        $duty->save();

        return redirect()->route('admin.duties')->with('success', 'Duty updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $duty = Duty::find($request->id);
        if ($duty) {
            $duty->status = $request->status;
            $duty->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Duty not found.'], 404);
    }
}
