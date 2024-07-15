<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function trainingList()
    {
        // Add your logic for training list view
        return view('admin.training'); // Example view path, adjust as per your structure
    }

    public function trainers()
    {
        // Add your logic for trainers view
        return view('admin.trainers'); // Example view path, adjust as per your structure
    }

    public function trainingType()
    {
        // Add your logic for training types view
        return view('admin.training-type'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
