<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DelayCode;
use App\Models\DelayCodeCategory;


class DelaycodeController extends Controller
{
    public function delay(Request $request){

        $categoryId = $request->query('category_id');

    $delayCodes = DelayCode::with('category') // Load the category relationship
        ->when($categoryId, function($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->get();

    $categories = DelayCodeCategory::all(); // To populate category dropdown in the view

    return view('admin.delay-code', compact('delayCodes', 'categories'));

    }



    public function store(Request $request)
    {
        $request->validate([
            'flight_number' => 'required|string',
            'date' => 'required|date',
            'category_id' => 'required|integer',
            'delay_duration' => 'required|integer',
            'description' => 'required|string',
        ]);

        DelayCode::create($request->all());
        return redirect()->route('admin.delay.code')->with('success', 'Delay Code added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'flight_number' => 'required|string',
            'date' => 'required|date',
            'category_id' => 'required|integer',
            'delay_duration' => 'required|integer',
            'description' => 'required|string',
        ]);

        $delayCode = DelayCode::find($id);
        $delayCode->update($request->all());
        return redirect()->route('admin.delay.code')->with('success', 'Delay Code updated successfully.');
    }
    public function destroy($id)
    {
        $delayCode = DelayCode::find($id);

        if (!$delayCode) {
            return redirect()->route('admin.delay.code')->with('error', 'Delay Code not found.');
        }

        $delayCode->delete();

        return redirect()->route('admin.delay.code')->with('success', 'Delay Code deleted successfully.');
    }
}
