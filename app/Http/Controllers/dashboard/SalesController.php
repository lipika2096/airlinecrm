<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function estimates()
    {
        // Add your logic for estimates view
        return view('admin.estimates'); // Example view path, adjust as per your structure
    }

    public function invoices()
    {
        // Add your logic for invoices view
        return view('admin.invoices'); // Example view path, adjust as per your structure
    }

    public function payments()
    {
        // Add your logic for payments view
        return view('admin.payments'); // Example view path, adjust as per your structure
    }

    public function expenses()
    {
        // Add your logic for expenses view
        return view('admin.expenses'); // Example view path, adjust as per your structure
    }

    public function providentFund()
    {
        // Add your logic for provident fund view
        return view('admin.provident-fund'); // Example view path, adjust as per your structure
    }

    public function taxes()
    {
        // Add your logic for taxes view
        return view('admin.taxes'); // Example view path, adjust as per your structure
    }
}
