<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FareType;
use App\Models\AirlineDiscount;
use App\Models\Airline;
use App\Models\AirlineDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = AirlineDiscount::with(['airline','faretype'])->get()->groupBy('airline_id');
        $fare_type = FareType::where('created_by', auth('admin')->user()->id)->get();
        $airline = AirlineDetail::where('deleted_at', NULL)->orWhere('deleted_at', 'null' )->with('airline')->get();
        return view('admin.discounts', compact('fare_type', 'airline','discounts'));
    }

    public function discountStore(Request $request)
    {
        // Add your logic for duties store
        $validator = Validator::make($request->all(),[
            'discount' => 'required|string|max:255'
        ]);

        $discount = new AirlineDiscount();
        $discount->fare_type = $request->input('fare_type_id');
        $discount->airline_id = $request->input('airline_id');
        $discount->discount = $request->input('discount');
        $discount->created_by = auth('admin')->user()->id;
        $discount->save();

        return redirect()->route('admin.discounts')->with('success', 'Discount created successfully.');
    }

    public function discountUpdate(Request $request, $id)
    {
        $discount = AirlineDiscount::findorFail($id);
        $discount->fare_type = $request->input('fare_type_id');
        $discount->airline_id = $request->input('airline_id');
        $discount->discount = $request->input('discount');
        $discount->updated_by = auth('admin')->user()->id;
        $discount->save();

        return redirect()->route('admin.discounts')->with('success', 'Discount updated successfully.');
    }

    public function discountDelete(Request $request, $id)
    {
        $discount = AirlineDiscount::find($id);
        if ($discount) {
            $discount->delete();
            return redirect()->route('admin.discounts')->with('success', 'Discount deleted successfully.');
        }
        return redirect()->route('admin.discounts')->with('error', 'Discount not found.');
    }
}
