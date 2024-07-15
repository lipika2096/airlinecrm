<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        // Add your logic for lead index view
        return view('admin.leads'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
