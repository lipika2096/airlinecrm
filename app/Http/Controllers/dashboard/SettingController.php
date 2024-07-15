<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Add your logic for settix view
        return view('admin.settings'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
