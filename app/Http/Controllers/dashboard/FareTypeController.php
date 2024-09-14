<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FareType;
use Illuminate\Support\Facades\Validator;

class FareTypeController extends Controller
{
    public function index()
    {
        $fare_type = FareType::all();
        return view('admin.faretypes', compact('fare_type'));
    }

    public function store(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'
        ]);

        $duty = new FareType();
        $duty->fare_type = $request->name;
        $duty->fare_type_name = str_replace(' ', '_', $request->name);
        $duty->save();

        return redirect()->route('admin.faretypes')->with('success', 'FareType created successfully.');
    }

    public function update(Request $request, $id)
    {
        $duty = FareType::findorFail($id);
        $duty->fare_type = $request->name;
        $duty->fare_type_name = str_replace(' ', '_', $request->name);
        $duty->save();

        return redirect()->route('admin.faretypes')->with('success', 'FareType updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        $duty = FareType::find($id);
        if ($duty) {
            $duty->delete();
            return redirect()->route('admin.faretypes')->with('success', 'FareType deleted successfully.');
        }
        return redirect()->route('admin.faretypes')->with('error', 'FareType not found.');
    }
}
