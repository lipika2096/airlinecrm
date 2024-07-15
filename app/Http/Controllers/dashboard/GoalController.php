<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function goalList()
    {
        // Add your logic for goal tracking view
        return view('admin.goal-tracking'); // Example view path, adjust as per your structure
    }

    public function goalType()
    {
        // Add your logic for goal types view
        return view('admin.goal-type'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
