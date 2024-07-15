<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function performanceIndicator()
    {
        // Add your logic for performance indicator view
        return view('admin.performance-indicator'); // Example view path, adjust as per your structure
    }

    public function performanceReview()
    {
        // Add your logic for performance review view
        return view('admin.performance'); // Example view path, adjust as per your structure
    }

    public function performanceAppraisal()
    {
        // Add your logic for performance appraisal view
        return view('admin.performance-appraisal'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
