<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesLead;

class SalesLeadController extends Controller
{
    public function index()
    {
        $salesLead = SalesLead::latest()->get();
        // Add your logic for lead index view
        return view('admin.sales_lead', compact('salesLead')); // Example view path, adjust as per your structure
    }
    public function store(Request $request)
    {
        // Create a new employee
        SalesLead::create([
            'company_name' => $request->input('company_name'),
            'website' => $request->input('website'),
            'email_id' => $request->input('email'),
            'phone' => $request->input('phone'),
            'contact_person' => $request->input('contact_person'),
            'category' => $request->input('category'),
        ]);

        return redirect()->route('admin.saleslead')->with('success', 'Employee added successfully');
    }
    public function update(Request $request, $id)
    {
        // Create a new employee
        $saleslead =  SalesLead::find($id);
        $saleslead->update([
            'company_name' => $request->input('company_name'),
            'website' => $request->input('website'),
            'email_id' => $request->input('email'),
            'phone' => $request->input('phone'),
            'contact_person' => $request->input('contact_person'),
            'category' => $request->input('category'),
        ]);
        return redirect()->route('admin.saleslead')->with('success', 'Employee added successfully');
    }

    // Add other methods as per your defined routes
}
