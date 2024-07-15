<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscriptionsAdmin()
    {
        // Add your logic for admin subscriptions view
        return view('admin.subscriptions'); // Example view path, adjust as per your structure
    }

    public function subscriptionsCompany()
    {
        // Add your logic for company subscriptions view
        return view('admin.subscriptions-company'); // Example view path, adjust as per your structure
    }

    public function subscribedCompanies()
    {
        // Add your logic for subscribed companies view
        return view('admin.subscribed-companies'); // Example view path, adjust as per your structure
    }

    // Add other methods as per your defined routes
}
