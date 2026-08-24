<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPackage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class SalesPackageController extends Controller
{
    public function index()
    {
        $packages = SalesPackage::where('created_by', auth('admin')->user()->id)->get();
        return view('admin.sales-packages.index', compact('packages'));
    }

    public function create()
    {
        $permissions = Permission::where('status', 'published')->get();
        return view('admin.sales-packages.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'annual_rate' => 'nullable|numeric|min:0',
            'modules' => 'required|array',
            'description' => 'nullable|string',
        ]);

        SalesPackage::create([
            'package_name' => $request->package_name,
            'rate' => $request->rate,
            'monthly_rate' => $request->monthly_rate,
            'annual_rate' => $request->annual_rate,
            'modules' => $request->modules,
            'description' => $request->description,
            'is_active' => true,
            'created_by' => auth('admin')->user()->id,
        ]);

        return redirect()->route('admin.sales-packages.index')->with('success', 'Sales package created successfully.');
    }

    public function edit($id)
    {
        $package = SalesPackage::find($id);
        $permissions = Permission::where('status', 'published')->get();
        return view('admin.sales-packages.edit', compact('package', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'annual_rate' => 'nullable|numeric|min:0',
            'modules' => 'required|array',
            'description' => 'nullable|string',
        ]);

        $package = SalesPackage::find($id);
        $package->update([
            'package_name' => $request->package_name,
            'rate' => $request->rate,
            'monthly_rate' => $request->monthly_rate,
            'annual_rate' => $request->annual_rate,
            'modules' => $request->modules,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.sales-packages.index')->with('success', 'Sales package updated successfully.');
    }

    public function destroy($id)
    {
        $package = SalesPackage::find($id);
        $package->delete();
        return redirect()->route('admin.sales-packages.index')->with('success', 'Sales package deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $package = SalesPackage::find($id);
        if ($package) {
            $package->is_active = !$package->is_active;
            $package->save();
            return redirect()->back()->with('success', 'Package status updated successfully.');
        }
        return redirect()->back()->with('error', 'Package not found.');
    }

    public function getPackage($id)
    {
        $package = SalesPackage::find($id);
        $package->modules_list = Permission::whereIn('id', $package->modules ?? [])
            ->pluck('name')
            ->implode(', ');
        $package->monthly_rate_formatted = $package->monthly_rate ? '$' . number_format($package->monthly_rate, 2) : '-';
        $package->annual_rate_formatted = $package->annual_rate ? '$' . number_format($package->annual_rate, 2) : '-';
        if ($package) {
            return response()->json($package);
        }
        return response()->json(['error' => 'Package not found'], 404);
    }
}
