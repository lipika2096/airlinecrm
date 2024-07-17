<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        $query = Sector::query();

        if ($request->has('q')) {
            $search = $request->get('q');
            $query->where('city_name', 'LIKE', "%{$search}%")
                  ->orWhere('airport_code', 'LIKE', "%{$search}%")
                  ->orWhere('country_code', 'LIKE', "%{$search}%");
        }

        $result = $query->paginate(10);
        return view('admin.sector', compact('result'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string|max:255',
            'airport_code' => 'required|string|max:10',
            'country_code' => 'required|string|max:255'
        ]);

        $sector = new Sector([
            'city_name' => $request->city_name,
            'airport_code' => $request->airport_code,
            'country_code' => $request->country_code
        ]);

        $sector->save();

        return redirect()->route('admin.sectors')->with('success', 'Sector added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city_name' => 'required|string|max:255',
            'airport_code' => 'required|string|max:10',
            'country_code' => 'required|string|max:255'
        ]);

        $sector = Sector::findOrFail($id);
        $sector->update([
            'city_name' => $request->city_name,
            'airport_code' => $request->airport_code,
            'country_code' => $request->country_code
        ]);

        return redirect()->route('admin.sectors')->with('success', 'Sector updated successfully');
    }

    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);
        $sector->delete();

        return redirect()->route('admin.sectors')->with('success', 'Sector deleted successfully');
    }
}
