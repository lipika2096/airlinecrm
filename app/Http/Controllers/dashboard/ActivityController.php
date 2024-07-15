<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Add your logic for activity index view
        return view('admin.activities'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
