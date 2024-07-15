<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KnowledgebaseController extends Controller
{
    public function index()
    {
        // Add your logic for knowledgebase index view
        return view('admin.knowledgebase'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
