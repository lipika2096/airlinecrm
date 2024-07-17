<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Airline;
use App\Models\Sector;


class InventoryController extends Controller
{

    public function index(Request $request)
    {
        $query = Inventory::query();
        $result = $query->with(['sector', 'airline', 'origin', 'destination'])->get();
        $sectors = Sector::all();
        $airlines = Airline::all();

        return view('admin.inventory', compact('result', 'airlines', 'sectors'));
    }


    public function expiryinventory(Request $request){

        return view('admin.expiry-inventory');
    }

    public function store(Request $request)
    {




        $inventory = new Inventory();
        $inventory->infant_id = $request->infant_id;
        $inventory->origin_id = $request->origin_id;
        $inventory->destination_id = $request->destination_id;
        $inventory->airline_id = $request->airline_id;
        $inventory->p_no = $request->p_no;
        $inventory->name = $request->name;
        $inventory->departure_date_from = $request->departure_date_from;
        $inventory->departure_time = $request->departure_time;
        $inventory->terminal = $request->terminal;
        $inventory->departure_date_to = $request->departure_date_to;
        $inventory->arrival_time = $request->arrival_time;
        $inventory->arrival_terminal = $request->arrival_terminal;
        $inventory->return_date = $request->return_date;
        $inventory->return_time = $request->return_time;
        $inventory->ret_terminal = $request->ret_terminal;
        $inventory->ret_flight_no = $request->ret_flight_no;
        $inventory->flight_no = $request->flight_no;
        $inventory->availabilty = $request->availabilty;
        $inventory->seat = $request->seat;
        $inventory->sales_stop_date = $request->sales_stop_date;
        $inventory->term = $request->term;
        $inventory->rate_type = $request->rate_type;
        $inventory->base_fair = $request->base_fair;
        $inventory->tax = $request->tax;
        $inventory->charges = $request->charges;
        $inventory->p_tax = $request->p_tax;
        $inventory->save();

        return redirect()->route('admin.inventories')->with('success', 'Inventory created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'infant_id' => 'required|string',
            'origin_id' => 'required|string',
            'destination_id' => 'required|string',
            'airline_id' => 'required|integer',
            'p_no' => 'required|string',
            'name' => 'required|string',
            'departure_date_from' => 'required|date',
            'departure_time' => 'required',
            'terminal' => 'required|string',
            'departure_date_to' => 'required|date',
            'arrival_time' => 'required',
            'arrival_terminal' => 'required|string',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable',
            'ret_terminal' => 'nullable|string',
            'ret_flight_no' => 'nullable|string',
            'flight_no' => 'required|string',
            'availability' => 'required|string',
            'seat' => 'required|integer',
            'sales_stop_date' => 'required|date',
            'term' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->fill($request->all());
        $inventory->save();

        return redirect()->route('admin.inventories')->with('success', 'Inventory updated successfully.');
    }

}
