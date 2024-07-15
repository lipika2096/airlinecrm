<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Add your logic for user index view
        return view('admin.users'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
