<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    public function tasks()
    {
        // Add your logic for tasks view
        return view('admin.tasks'); // Example view path, adjust as per your structure
    }

    public function taskBoard()
    {
        // Add your logic for task board view
        return view('admin.task-board'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
