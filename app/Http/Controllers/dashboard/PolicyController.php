<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Client;
use App\Models\Department;


class PolicyController extends Controller
{
    public function index()
    {
        $policy = Policy::latest()->get();
         $staff = Client::get();
         $department = Department::latest()->get();
        // Add your logic for policy index view
        return view('admin.policies', compact('policy','staff', 'department')); // Example view path, adjust as per your structure
    }
    
    public function store(Request $request){
        Policy::create([
            'policy_name'=> $request->input('policy_name'),
            'department_id'=> $request->input('department'),
            'description'=> $request->input('description'),
            ]);
            return redirect()->route('admin.policies');
    }
    
    public function update( Request $request, $id){
        $policy = Policy::find($id);
        $policy->update([
            'policy_name'=> $request->input('policy_name'),
            'department_id'=> $request->input('department'),
            'description'=> $request->input('description'),
            ]);
            return redirect()->route('admin.policies');
    }

    // Add other methods as per your defined routes
}
