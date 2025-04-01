<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function employeeProfile()
    {
        // Add your logic for employee profile view
        $email = session('email');
        $employee = Employee::where('email', $email)->first();
        $profile = Employee::where('id', $employee->id)->first();
        return view('admin.client-profile', compact('profile')); // Example view path, adjust as per your structure
    }

    public function clientProfile()
    {
        // Add your logic for client profile view
        return view('admin.client-profile'); // Example view path, adjust as per your structure
    }

    public function adminProfile()
    {
        // Add your logic for client profile view

        $customer = Admin::with(['adminDetail', 'kycDocuments'])->find(auth('admin')->user()->id);
        return view('admin.profile', compact('customer')); // Example view path, adjust as per your structure
    }


    // Add other methods as per your defined routes
}
