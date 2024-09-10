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
         $staff = Client::join('users', 'users.clientid', '=', 'clients.client_id')
         ->get(['clients.*', 'users.*']);
         $department = Department::latest()->get();
        // Add your logic for policy index view
        return view('admin.policies', compact('policy','staff', 'department')); // Example view path, adjust as per your structure
    }

    public function store(Request $request){

        if ($request->hasFile('policy_doc')) {
            // Retrieve the uploaded file
            $docName = $request->file('policy_doc');
            // Generate a unique name for the file
            $mediaName = uniqid() . '.' . $docName->getClientOriginalExtension();
            // Move the file to the public directory
            $mediaPath = $docName->move('public/assets/docs/', $mediaName);
            if (!$mediaPath) {
            return back()->withErrors(['media' => 'Failed to upload banner image']);
            }
        }

        Policy::create([
            'policy_name'=> $request->input('policy_name'),
            'department_id'=> $request->input('department'),
            'description'=> $request->input('description'),
            'policy_doc' => $mediaName
            ]);
            return redirect()->route('admin.policies');
    }

    public function update( Request $request, $id){
        $policy = Policy::find($id);
        if ($request->hasFile('policy_doc')) {
            // Retrieve the uploaded file
            $docName = $request->file('policy_doc');

            // Generate a unique name for the file
            $mediaName = uniqid() . '.' . $docName->getClientOriginalExtension();
            // Move the file to the public directory
            $mediaPath = $docName->move('public/assets/docs/', $mediaName);
            if (!$mediaPath) {
            return back()->withErrors(['media' => 'Failed to upload banner image']);
            }
        }
        else{
            $mediaName = $policy->policy_doc;
        }
        $policy->update([
            'policy_name'=> $request->input('policy_name'),
            'department_id'=> $request->input('department'),
            'description'=> $request->input('description'),
            'policy_doc' => $mediaName
            ]);
            return redirect()->route('admin.policies');
    }

    // Add other methods as per your defined routes
}
