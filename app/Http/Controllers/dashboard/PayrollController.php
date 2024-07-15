<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\EmployeeSalary;

class PayrollController extends Controller
{
    public function employeeSalary()
    {
     $employeeSalary = EmployeeSalary::latest()->get();   
     $staff = Client::get();
        // Add your logic for employee salary view
        return view('admin.salary',compact('employeeSalary', 'staff')); // Example view path, adjust as per your structure
    }
    
    public function employeeSalaryStore(Request $request){
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
            ]);
            return redirect()->route('admin.salary');
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
