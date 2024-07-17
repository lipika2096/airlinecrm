<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Termination;
use App\Models\Resignation;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    public function promotion()
    {
        // Add your logic for promotion view
        return view('admin.promotion'); // Example view path, adjust as per your structure
    }

    public function resignation()
    {
        $resignation = Resignation::latest()->get();
         $staff = Client::get();
        // Add your logic for resignation view
        return view('admin.resignation', compact('resignation', 'staff')); // Example view path, adjust as per your structure
    }

    public function Employeeresignation()
    {
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        $resignation = Resignation::where('employee_id', $employee->id)->get();
        // Add your logic for resignation view
        return view('admin.employee-resignation', compact('resignation')); // Example view path, adjust as per your structure
    }

    public function termination()
    {
        $termination = Termination::latest()->get();
         $staff = Client::get();
        // Add your logic for termination view
        return view('admin.termination',  compact('termination', 'staff')); // Example view path, adjust as per your structure
    }

    public function resignationStore(Request $request)
    {
         Resignation::create([
            'employee_id'=> $request->input('employee_id'),
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'resignation_date'=> $request->input('resignation_date'),
            ]);
        // Add your logic for resignation view
        return redirect()->route('admin.resignation'); // Example view path, adjust as per your structure
    }
    public function EmployeeresignationStore(Request $request)
    {
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
         Resignation::create([
            'employee_id'=> $employee->id,
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'resignation_date'=> $request->input('resignation_date'),
            ]);
        // Add your logic for resignation view
        return redirect()->route('employee.resignation'); // Example view path, adjust as per your structure
    }

    public function terminationStore(Request $request)
    {
        Termination::create([
            'employee_id'=> $request->input('employee_id'),
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'termination_date'=> $request->input('termination_date'),
            'termination_type'=> $request->input('termination_type'),
            ]);
        // Add your logic for termination view
        return redirect()->route('admin.termination'); // Example view path, adjust as per your structure
    }

    public function resignationUpdate(Request $request, $id)
    {
        $resignation = Resignation::find($id);
        $resignation->update([
            'employee_id'=> $request->input('employee_id'),
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'resignation_date'=> $request->input('resignation_date'),
            ]);
        // Add your logic for resignation view
        return redirect()->route('admin.resignation'); // Example view path, adjust as per your structure
    }

    public function EmployeeresignationUpdate(Request $request, $id)
    {
        $resignation = Resignation::find($id);
        $resignation->update([
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'resignation_date'=> $request->input('resignation_date'),
            ]);
        // Add your logic for resignation view
        return redirect()->route('employee.resignation'); // Example view path, adjust as per your structure
    }

    public function terminationUpdate(Request $request, $id)
    {
        $termination = Termination::find($id);
        $termination->update([
            'employee_id'=> $request->input('employee_id'),
            'reason'=> $request->input('reason'),
            'notice_date'=> $request->input('notice_date'),
            'termination_date'=> $request->input('termination_date'),
            'termination_type'=> $request->input('termination_type'),
            ]);
        return redirect()->route('admin.termination'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
