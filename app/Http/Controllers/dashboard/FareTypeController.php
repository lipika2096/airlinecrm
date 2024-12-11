<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FareType;
use App\Models\AirlineDiscount;
use App\Models\Airline;
use App\Models\AirlineDetail;
use Illuminate\Support\Facades\Validator;

class FareTypeController extends Controller
{
    public function index()
    {
        $fare_type = FareType::all();
        $airline = AirlineDetail::where('deleted_at', NULL)->orWhere('deleted_at', 'null' )->with('airline')->get();
        return view('admin.faretypes', compact('fare_type', 'airline'));
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

    public function discountStore(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'discount' => 'required|string|max:255'
        ]);

        $discount = new AirlineDiscount();
        $discount->fare_type = $request->input('fare_type');
        $discount->airline_id = $request->input('airline_id');
        $discount->discount = $request->input('discount');
        $discount->save();

        return redirect()->route('admin.faretypes')->with('success', 'Discount created successfully.');
    }

    public function discountUpdate(Request $request, $id)
    {
        $discount = AirlineDiscount::findorFail($id);
        $discount->fare_type = $request->input('fare_type');
        $discount->airline_id = $request->input('airline_id');
        $discount->discount = $request->input('discount');
        $discount->save();

        return redirect()->route('admin.faretypes')->with('success', 'Discount updated successfully.');
    }

    public function discountDelete(Request $request, $id)
    {
        $discount = AirlineDiscount::find($id);
        if ($discount) {
            $discount->delete();
            return redirect()->route('admin.faretypes')->with('success', 'Discount deleted successfully.');
        }
        return redirect()->route('admin.faretypes')->with('error', 'Discount not found.');
    }
}
