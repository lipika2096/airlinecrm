<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Client;
use App\Models\EmployeeSalary;

class PayrollController extends Controller
{

    public function employeeSalaryId($id)
    {
        // Fetch the salary data for the specific user
        $employeeSalaryId = EmployeeSalary::where('employee_id', $id)->latest()->get();

        // Fetch the user information
        $staff = Client::join('users', 'users.clientid', '=', 'clients.client_id')
            ->where('users.id', $id)
            ->first(['clients.*', 'users.*']);

        // Return the view with the filtered data and employee ID
        return view('admin.manage-salary', compact('employeeSalaryId', 'staff', 'id'));
    }

    public function employeeSalary()
    {
        $employeeSalary = EmployeeSalary::latest()->get();
        $staff = Client::join('users', 'users.clientid', '=', 'clients.client_id')
             ->get(['clients.*', 'users.*']);
    //Add your logic for employee salary view
        return view('admin.salary',compact('employeeSalary', 'staff')); // Example view path, adjust as per your structure
    }

    public function employeeSalaryStore(Request $request){
        if ($request->hasFile('salary_doc')) {
            // Retrieve the uploaded file
            $docName = $request->file('salary_doc');

            // Generate a unique name for the file
            $mediaName = uniqid() . '.' . $docName->getClientOriginalExtension();
            // Move the file to the public directory
            $mediaPath = $docName->move('public/assets/docs/', $mediaName);
            if (!$mediaPath) {
            return back()->withErrors(['media' => 'Failed to upload banner image']);
            }
        }
        else{
            $mediaName = null;
        }
            $payslip_id = random_int(10000, 99999);
        EmployeeSalary::create([
            'employee_id' => $request->input('employee_id'),
            'basic' => $request->input('basic'),
            'da' => $request->input('da'),
            'hra' => $request->input('hra'),
            'conveyance' => $request->input('conveyance'),
            'allowance' => $request->input('allowance'),
            'medical_allowance' => $request->input('medical_allowance'),
            'tds' => $request->input('tds'),
            'esi' => $request->input('esi'),
            'pf' => $request->input('pf'),
            'leave_dd' => $request->input('leave_dd'),
            'prof_tax' => $request->input('prof_tax'),
            'labour_welfare' => $request->input('labour_welfare'),
            'salary' => $request->input('netsalary'),
            'payslip_id' => $payslip_id,
            'pay_for_month' => $request->input('month') ." ". $request->input('year'),
            'salary_doc' => $mediaName
            ]);
            return redirect()->route('admin.salary');
    }
   
    //Add manage salary

    public function employeeSalaryIdStore(Request $request)
    {
        if ($request->hasFile('salary_doc')) {
            // Retrieve the uploaded file
            $docName = $request->file('salary_doc');

            // Generate a unique name for the file
            $mediaName = uniqid() . '.' . $docName->getClientOriginalExtension();
            // Move the file to the public directory
            $mediaPath = $docName->move('public/assets/docs/', $mediaName);
            if (!$mediaPath) {
                return back()->withErrors(['media' => 'Failed to upload document']);
            }
        } else {
            $mediaName = null;
        }

        $payslip_id = random_int(10000, 99999);

        // Create the EmployeeSalary record
        EmployeeSalary::create([
            'employee_id' => $request->input('employee_id'),
            'basic' => $request->input('basic'),
            'da' => $request->input('da'),
            'hra' => $request->input('hra'),
            'conveyance' => $request->input('conveyance'),
            'allowance' => $request->input('allowance'),
            'medical_allowance' => $request->input('medical_allowance'),
            'tds' => $request->input('tds'),
            'esi' => $request->input('esi'),
            'pf' => $request->input('pf'),
            'leave_dd' => $request->input('leave_dd'),
            'prof_tax' => $request->input('prof_tax'),
            'labour_welfare' => $request->input('labour_welfare'),
            'salary' => $request->input('netsalary'),
            'payslip_id' => $payslip_id,
            'pay_for_month' => $request->input('month') . " " . $request->input('year'),
            'salary_doc' => $mediaName
        ]);

        // Redirect back to the specific employee's salary management page
        return redirect()->route('admin.manage-salary', ['id' => $request->input('employee_id')]);
    }


    public function payslip($id)
    {
        // Add your logic for payslip view
        $paySlip = EmployeeSalary::find($id);
        return view('admin.salary-view', compact('paySlip')); // Example view path, adjust as per your structure
    }

    public function payrollItems()
    {
        // Add your logic for payslip view
        return view('admin.payroll-items'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
