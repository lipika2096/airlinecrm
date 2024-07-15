<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function employeeProfile()
    {
        // Add your logic for employee profile view
        return view('admin.profile'); // Example view path, adjust as per your structure
    }

    public function clientProfile()
    {
        // Add your logic for client profile view
        return view('admin.client-profile'); // Example view path, adjust as per your structure
    }

    public function adminProfile()
    {
        // Add your logic for client profile view
        return view('admin.profile'); // Example view path, adjust as per your structure
    }


    // Add other methods as per your defined routes
}
