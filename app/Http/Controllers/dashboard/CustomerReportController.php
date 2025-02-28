<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class CustomerReportController extends Controller
{
    public function customerReport(Request $request)
    {
        $customers = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();
        $customer_id = $request->customer_id;
        $searchedCustomer = Admin::where('id',$customer_id)->with(['adminDetail','kycDocuments'])->get();

        return view('admin.customer-reports', compact('customers','customer_id','searchedCustomer'));
    }

}
